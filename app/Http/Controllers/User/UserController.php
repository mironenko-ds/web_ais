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
use App\Services\SortUserWork;
use App\Services\UserInfoService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $re)
    {
        if($re->input('val-date-1')){
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = ? and created_at >= ? + ?
            group by month(created_at)", array(Auth::user()->employee->id,
            $re->input('val-date-1'),
            $re->input('val-date-2')));
        }else{
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = 7 and created_at >= '2020-01-12' + '2020-02-12'
            group by month(created_at)");
        }
        $count_work_good = PlanWork::where([
            'employee_id' => Auth::user()->employee->id,
            'status' => 1
            ])->count();
        $count_work_time = PlanWork::where([
            'employee_id' => Auth::user()->employee->id,
            'status' => 0
            ])->count();

        try {
            $old_date = PlanWork::where([
            'employee_id' => Auth::user()->employee->id,
            'status' => 1
            ])
            ->select('created_at')
            ->orderBy('created_at', 'asc')
            ->first()->created_at->format('Y-m-d');

        $max_date = PlanWork::where([
            'employee_id' => Auth::user()->employee->id,
            'status' => 1
            ])
            ->select('created_at')
            ->orderBy('created_at', 'desc')
            ->first()->created_at->format('Y-m-d');
        } catch (\Throwable $th) {
            //throw $th;
        }

        $allTypeWork = TypeWork::all();
        $type_work_count = array();
        foreach ($allTypeWork as $item) {
            $count = DB::select("
                SELECT count(*) as cn FROM plan_works
                LEFT JOIN works on plan_works.work_id = works.id
                LEFT JOIN works_kinds ON works.works_kinds_id = works_kinds.id
                LEFT JOIN `type-works` ON works_kinds.type_work_id =  `type-works`.id
                WHERE plan_works.employee_id = ? AND `type-works`.name_type_work = ?
            ", array(Auth::user()->employee->id, $item->name_type_work));

            $type_work_count[$item->name_type_work] = $count[0]->cn;
        }

        return view('user.index', compact('user_email', 'type_work_count', 'resultDateFirst', 'max_date', 'count_work_good', 'count_work_time','old_date'));
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
            return redirect()->route('new.user')->with(['success' => 'Заявку відправлено! Після обробки заявки ми вам надішлемо лист на пошту з результатом.']);
        }else{
            return back()->with(['errorAdd' => 'Заявка не відправлена! Спробуйте вказати інші дані'])->withInput();

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

    public function myWorks(Request $request){

        $user_id = Auth::user()->employee->id;
        $get_req = array();

        if($request->input('value') && $request->input('type-sort')){
           $result = SortUserWork::sort($request, $user_id);
           $works = $result['value'];
           $get_req = $result['get'];
        }else{
            $works = PlanWork::where([
                ['employee_id', '=', $user_id],
                ['status', '=', 1]
            ])
            ->with('work')
            ->paginate(15);
        }
        if($works->count() == 0){ // записи отсутствуют
            return view('user.my-works', ['noWorks' => 'Роботи відсутні']);
        }else{
            return view('user.my-works', compact('works', 'get_req'));
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

        return redirect()->route('user.works')->with(['successSend' => 'Ваше повідомлення надіслано']);

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
        return redirect()->route('user.feedback')->with(['successFeedback' => 'Ваше повідомлення надіслано.']);


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

        return redirect()->route('user.account')->with(['successSend' => 'Повідомлення відправлено!']);

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
            return back()
                ->with(['errorMake' => $th->getMessage()])
                ->withInput();
        }
        return redirect()
            ->route('user.addWork')
            ->with(['successWork' => 'Робота додана! На протязі декількох днів модератор обробить вашу роботу.']);
    }
    public function MyMessage(Request $request){

        $user_id = Auth::user()->id;
        $get_req = array();

        if($request->input('value') && $request->input('type-sort')){
            switch ($request->input('value')) {
                case '1':
                        if($request->input('type-sort') == 'desc'){
                            $answers = FeedbackAnser::orderBy('asked_user_read', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'desc';
                        }else{
                            $answers = FeedbackAnser::orderBy('asked_user_read', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 1; $get_req['type']= 'asc';
                        }
                    break;
                case '2':
                        if($request->input('type-sort') == 'desc'){
                            $answers = FeedbackAnser::orderBy('created_at', 'desc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'desc';
                        }else{
                            $answers = FeedbackAnser::orderBy('created_at', 'asc')
                                ->where('asked_user', '=', $user_id)
                                ->with('user_answered', 'feedback')
                                ->paginate(15);
                            $get_req['val'] = 2; $get_req['type']= 'asc';
                        }
                    break;
                default:
                    # code...
                    break;
            }
        }else{
        $answers = FeedbackAnser::orderBy('id', 'desc')
            ->where('asked_user', '=', $user_id)
            ->with('user_answered', 'feedback')
            ->paginate(15);
        }


        if($answers->count() == 0){ // записи отсутствуют
            return view('user.my-message', ['noMessage' => 'Повідомлення відсутні']);
        }else{
            $count_no_read = FeedbackAnser::where([['asked_user_read', '=', false],['asked_user', '=', $user_id]])->count();

            return view('user.my-message', compact('answers', 'count_no_read', 'get_req'));
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
