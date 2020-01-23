<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Post;
use App\Models\User;
use App\Models\AcademicDegree;
use App\Models\Departments;
use App\Models\Facultes;
use App\Models\AccountCreationRequest;
use App\Models\Feedback;
use App\Models\TypeWork;
use App\Models\Work;
use App\Models\WorkKind;

use App\Http\Requests\UserInsertRequest;
use App\Http\Requests\ResetEmailRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\SendMessageUserRequest;
use App\Http\Requests\NewWorkRequest;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Services\AddFileService;
use App\Services\MakeWorkService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_email = Auth::user()->getRole();
        return view('user.index', compact('user_email'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Request\UserInsertRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserInsertRequest $request)
    {
        $validated = $request->validated();
        $validated['password_no_hash'] = Str::random(14);
        $userRequest = new AccountCreationRequest($validated);
        $userRequest->save();

        if($userRequest){
            return redirect()->route('new.user')->with(['success' => 'Заявка отправлена! После обработки заявки мы вам отправим письмо на почту с результатом.']);
        }else{
            return back()->with(['errorAdd' => 'Заявка не отправлена! Попробуйте указать другие данные'])->withInput();

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function account(){

        $user = Auth::user();

        $userName = $user->employee->name;
        $surName = $user->employee->surname;
        $patronymic = $user->employee->patronymic;
        $email = $user->email;
        $facultyName = $user->employee->departament->faculty->faculty_name;
        $departamentName =  $user->employee->departament->departament_name;
        $degreeName = $user->employee->degree->degree_name;
        $userPost = $user->employee->post->post_name;

        return view('user.account', compact('userName', 'surName', 'patronymic', 'email',
                            'facultyName', 'departamentName', 'degreeName', 'userPost'));
    }

    public function myWorks(){
        return view('user.my-works');
    }
    public function addWork(){
        $user = Auth::user();
        $employee = $user->employee->name . ' ' . $user->employee->surname . ' ' . $user->employee->patronymic;
        $facultyName = $user->employee->departament->faculty->faculty_name;
        $departamentName =  $user->employee->departament->departament_name;
        $year = Carbon::now()->year;
        $date = Carbon::today()->toDateString();

        $work_kinds = WorkKind::all();
        $works = Work::all();
        $type_work = TypeWork::all();

        $jsonWork = response()->json($works);
        $jsonWorkKinds = response()->json($work_kinds);
        $jsonTypeWork = response()->json($type_work);

        return view('user.add-work', compact('works' ,'work_kinds','type_work' ,'employee', 'facultyName', 'departamentName', 'year', 'date', 'jsonWork', 'jsonWorkKinds', 'jsonTypeWork'));
    }
    public function feedback(){
        return view('user.feedback');
    }

    public function sendMessageUser(SendMessageUserRequest $request){

        $validated = $request->validated();

        $message = new Feedback;
        $tema = $validated['tema'];
        $message->title = $tema;
        $message->user_id = Auth::user()->id;
        $message->content = $validated['content'];
        $message->type_user = $validated['type-user'];

        // files
        $folder_hash = md5($tema . Carbon::now('Europe/Kiev')->toDateTimeString());

        if($request->file('attachment')){
            // json объект
            $jsonObj = array();
            $directory = 'app/uploads/' . Auth::user()->id . '/feedback';
            // добавление файлов если папка создана
            if(Storage::disk('public')->exists($directory)){
                // создание уникальной папки
                $unic_folder = $directory . '/' . $folder_hash;
                Storage::disk('public')->makeDirectory($unic_folder);
                // загрузка в эту папку
                foreach($request->file('attachment') as $file){
                    $fName = $file->getClientOriginalName();
                    $value = $file->storeAs($unic_folder, $fName, 'public');
                    array_push($jsonObj, $value);
                }
                // добавление файлов если папка не создана
            }else{
                // создание папки и загрузка
                Storage::disk('public')->makeDirectory($directory);
                // создание уникальной папки
                $unic_folder = $directory . '/' . $folder_hash;
                Storage::disk('public')->makeDirectory($unic_folder);
                // загрузка в эту папку
                foreach($request->file('attachment') as $file){
                    $fName = $file->getClientOriginalName();
                    $value = $file->storeAs($unic_folder, $fName, 'public');
                    array_push($jsonObj, $value);
                }
            }
            $message->materials = json_encode($jsonObj);
        }
        $message->save();
        return redirect()->route('user.feedback')->with(['successFeedback' => 'Ваше сообщение отправлено.']);


    }

    public function work($id){
       return view('user.work', compact('id'));
    }

    public function newUser(){

        $posts = Post::all();
        $degrees = AcademicDegree::all();
        $departaments = Departments::all();
        $facultes = Facultes::all();
        $allDep = response()->json($departaments);
        return view('user.new-user', compact('posts', 'degrees', 'allDep', 'facultes'));
    }

    public function resetEmail(ResetEmailRequest $request){

        $validated = $request->validated();
        $userId = Auth::user()->id;
        $value = User::where('id', $userId)->update(['email'=> $validated['new-email']]);

        if($value){
            return redirect()->route('user.account')->with(['successEmail' => 'Почта обновлена.']);
        }else{
            return back()->with(['errorReset' => 'Почта не обновлена! Попробуйте еще раз'])->withInput();

        }
    }

    public function resetPassword(ResetPasswordRequest $request){
        $validated = $request->validated();
        if(!Hash::check($validated['old-password'], Auth::user()->password)){
            return back()->with(['errorPass' => 'Введенный вами пароль не совпадает с старым паролем!']);
        }

        $userId = Auth::user()->id;
        $passHash = Hash::make($validated['new-password']);
        $value = User::where('id', $userId)->update(['password'=> $passHash]);

        if($value){
            return redirect()->route('user.account')->with(['successPass' => 'Пароль обновлен!']);
        }else{
            return back()->with(['errorPass' => 'Пароль не обновлен! Попробуйте еще раз']);

        }
    }

     function sendMessage(DeleteAccountRequest $request)
    {
        $validated = $request->validated();
        $title = 'Удаление аккаунта';

        $deletePost = new Feedback;

        $deletePost->user_id = Auth::user()->id;
        $deletePost->title = $title;
        $deletePost->content = $validated['content-message'];
        $deletePost->type_user = 2;

        $deletePost->save();

        return redirect()->route('user.account')->with(['successSend' => 'Сообщение отправлено!']);

    }


    public function CreateWork(NewWorkRequest $request){

        $validated = $request->validated();

        $work = MakeWorkService::make($validated);

        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('works');  // отправляем файлы в папку app/uploads/{id}/works/hash/files
            $work->materials = json_encode($json);
        }

        try {
            $work->save();
        } catch (\Throwable $th) {
            return back()->with(['errorMake' => $th->getMessage()])->withInput();
        }


        return redirect()->route('user.addWork')->with(['successWork' => 'Работа добавлена! В течении нескольких дней модератор обработает вашу работу.']);
    }
}
