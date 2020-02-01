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
use App\Http\Requests\ValidChangeRequestWork;
use App\Models\FeedbackAnser;
use App\Models\PlanWork;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Services\AddFileService;
use App\Services\MakeWorkService;
use App\Services\SendUserMessage;
use App\Services\UserInfoService;
use Illuminate\Http\Response;

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

        $info = UserInfoService::info();

        return view('user.account', $info);
    }

    public function myWorks(){

        $user_id = Auth::user()->employee->id;

        $works = PlanWork::where([
            ['employee_id', '=', $user_id],
            ['status', '=', 1]
        ])->paginate(15);

        if($works->count() == 0){ // записи отсутствуют
            return view('user.my-works', ['noWorks' => 'Работы отсутсвуют']);
        }else{
            return view('user.my-works', compact('works'));
        }
    }

    public function EditWork(ValidChangeRequestWork $request)
    {
        $valid = $request->validated();

        $sendMessage = SendUserMessage::send(
            $valid['tema'], $valid['content'], Auth::user()->id
        );

        try {
            $sendMessage->save();
        } catch (\Throwable $th) {
            return back()->with(['errorSendMessage' => $th->getMessage()]);
        }

        return redirect()->route('user.works')->with(['successSend' => 'Ваше сообщение отправлено']);

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
        $message->departament_id = Auth::user()->employee->department_id;

        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('feedback');
            $message->materials = json_encode($json);
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
            if(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.account')->with(['successEmail' => 'Пошта оновлена.']);
            }elseif(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.account')->with(['successEmail' => 'Пошта оновлена.']);
            }elseif(Auth::user()->role->role_name == 'admin'){
                return redirect()->route('admin.account')->with(['successEmail' => 'Пошта оновлена.']);
            }
        }else{
            return back()->with(['errorReset' => 'Пошта не оновлена! Спробуйте ще раз'])->withInput();
        }
    }

    public function resetPassword(ResetPasswordRequest $request){
        $validated = $request->validated();
        if(!Hash::check($validated['old-password'], Auth::user()->password)){
            return back()->with(['errorPass' => 'Введений вами пароль не збігається з старим паролем!']);
        }

        $userId = Auth::user()->id;
        $passHash = Hash::make($validated['new-password']);
        $value = User::where('id', $userId)->update(['password'=> $passHash]);

        if($value){
            if(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.account')->with(['successPass' => 'Пароль оновлено!']);
            }elseif(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.account')->with(['successPass' => 'Пароль оновлено!']);
            }elseif(Auth::user()->role->role_name == 'admin'){
                return redirect()->route('admin.account')->with(['successPass' => 'Пароль оновлено!']);
            }
        }else{
            return back()->with(['errorPass' => 'Пароль не оновлено! Спробуйте ще раз']);

        }
    }

     function sendMessage(DeleteAccountRequest $request)
    {
        $validated = $request->validated();
        $title = 'Видалення акаунта';

        $deletePost = new Feedback;

        $deletePost->user_id = Auth::user()->id;
        $deletePost->title = $title;
        $deletePost->content = $validated['content-message'];
        $deletePost->type_user = 2;
        $deletePost->departament_id = Auth::user()->employee->department_id;
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
    public function MyMessage(){

        $user_id = Auth::user()->id;

        $answers = FeedbackAnser::orderBy('id', 'desc')->where('asked_user', '=', $user_id)->paginate(15);

        if($answers->count() == 0){ // записи отсутствуют
            return view('user.my-message', ['noMessage' => 'Сообщения отсутсвуют']);
        }else{
            $count_no_read = FeedbackAnser::where([['asked_user_read', '=', false],['asked_user', '=', $user_id]])->count();

            return view('user.my-message', compact('answers', 'count_no_read'));
        }
    }

    public function deleteAllMessage(Request $request){

        $user_id = Auth::user()->id;

        try {
            FeedbackAnser::where('asked_user', '=', $user_id)->delete();
        } catch (\Throwable $th) {
            return back()->with(['errorDeleteAll' => $th->getMessage()]);
        }
        if(Auth::user()->role->role_name == 'user'){
            return redirect()->route('user.message')->with(['successDeleteAll' => 'Повідомлення видалені!']);
        }elseif(Auth::user()->role->role_name == 'moderator'){
            return redirect()->route('moderator.myMessage')->with(['successDeleteAll' => 'Повідомлення видалені!']);
        }
    }

    public function changeStatusMessage(Request $request, $id){

        $user_id = Auth::user()->id;

        if(FeedbackAnser::where([
            ['asked_user', '=', $user_id],
            ['id', '=', $id ]
        ])->count() != 0){
            FeedbackAnser::where('id', '=', $id)->update(['asked_user_read' => true]);
        }
    }

    public function deleteMessage(Request $request, $id){
        $user_id = Auth::user()->id;

        if(FeedbackAnser::where([
            ['asked_user', '=', $user_id],
            ['id', '=', $id ]
        ])->count() != 0){
            FeedbackAnser::where('id', '=', $id)->delete();
            if(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.message');
            }elseif(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.myMessage');
            }
        }else{
            if(Auth::user()->role->role_name == 'user'){
                return redirect()->route('user.message');
            }elseif(Auth::user()->role->role_name == 'moderator'){
                return redirect()->route('moderator.myMessage');
            }
        }
    }
}
