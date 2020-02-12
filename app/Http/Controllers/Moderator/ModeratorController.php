<?php

namespace App\Http\Controllers\Moderator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewWorkRequest;
use App\Models\AcademicDegree;
use App\Models\Departments;
use App\Models\Employee;
use App\Models\Facultes;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Services\UserInfoService;
use App\Http\Requests\UserEditRequest;
use App\Http\Requests\SendMessageUserRequest;
use App\Models\AccountCreationRequest;
use App\Models\Feedback;
use App\Models\FeedbackAnser;
use App\Models\PlanWork;
use App\Models\TypeWork;
use App\Models\Work;
use App\Models\WorkKind;
use App\Services\AddFileService;
use App\Services\MakeWorkService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

use App\Services\IdDepartament;
use App\Services\GetInfoUniversity;
use App\Repositories\EmployeeRepository;
use App\Services\GetSortEmployee;
use App\Services\GetSortUserRequest;
use App\Services\ModeratorSortMessage;
use App\Services\SortUserQuestion;
use App\Services\SortUserRequestWork;
use Illuminate\Support\Facades\DB;

class ModeratorController extends Controller
{

    private $employeeRepository;

    public function __construct(EmployeeRepository $employeeRepository)
    {
        $this->employeeRepository = $employeeRepository;
    }

    public function index(Request $re)
    {
        $employees = Employee::where('department_id', '=', Auth::user()->employee->department_id)->get();
        $user_id = '';
        if($re->input('user')){
            $user_id = $re->input('user');
        }else{
            $user_id = Auth::user()->employee->id;
        }

        if($re->input('val-date-1')){
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = ? and created_at >= ? + ?
            group by month(created_at)", array($user_id ,
            $re->input('val-date-1'),
            $re->input('val-date-2')));
        }else{
            $resultDateFirst = DB::select("select month(created_at) as mn, count(*) as cont
            from plan_works
            where employee_id = ? and created_at >= '2020-01-12' + '2020-02-12'
            group by month(created_at)", array($user_id ));
        }
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
        $old_date = '';
        $max_date = '';
       }
       $select_user = Auth::user()->employee->id;
       if($re->input('select')){
        $select_user = $re->input('user-area');
        $isSelected = true;
       }else{
           $isSelected = false;
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
            ", array($select_user, $item->name_type_work));

            $type_work_count[$item->name_type_work] = $count[0]->cn;
        }
        $count_work = PlanWork::where('departament_id', '=', Auth::user()->employee->department_id)->count();
        $count_people = Employee::where('department_id', '=', Auth::user()->employee->department_id)->count();
        $count_req = AccountCreationRequest::where('departament', '=', Auth::user()->employee->department_id)->count();
        return view('moderator.index', compact('count_req', 'count_people', 'count_work', 'isSelected', 'employees', 'user_email', 'type_work_count', 'resultDateFirst', 'max_date', 'count_work_good', 'count_work_time','old_date'));
    }

    public function account(){

        $info = UserInfoService::info();

        return view('moderator.account', $info);
    }

    public function employees(Request $request){
        $result = array(); $get_req = '';
        $dep_id = IdDepartament::get();
        $users = ''; $get_req = array();

        $val = GetSortEmployee::sort($request, $dep_id);

        $users = $this->employeeRepository
            ->getByDepartament($dep_id, true)
            ->paginate(15);

        if($request->input('value') && $request->input('type-sort')){
            $val = GetSortEmployee::sort($request, $dep_id);
            $users = $val['value']; $get_req = $val['get'];
        }else{
            $users = $this->employeeRepository
            ->getByDepartament($dep_id, true)
            ->paginate(15);
        }




        if($users->count()){
            $university = GetInfoUniversity::get();
            return view('moderator.employee', compact('users', 'university', 'get_req'));
        }else{
            $UsersEmpty = 'Користувачі відсутні';
            return view('moderator.employee', compact('UsersEmpty'));
        }
    }

    public function employeesDelete(Request $request){
        $id = $request->input('user_id');
        try {
            $user_id = User::where('id', '=', $id)->get()[0];
        } catch (\Throwable $th) {
            return redirect()->route('moderator.employees');
        }
        $moder_id = Auth::user()->employee->department_id;
        if($user_id->employee->department_id == $moder_id){
            $user_id->delete();
            $user_id->employee->delete();
            return redirect()->route('moderator.employees')->with(['successDelete' => 'Користувач був видалений']);
        }
        return redirect()->route('moderator.employees');
    }

    public function employeesEdit(UserEditRequest $request){
        $valid = $request->validated();

        $id = $valid['user_id'];
        $user_id = '';
        try {
            $user_id = User::where('id', '=', $id)->first();
        } catch (\Throwable $th) {
            return redirect()->route('moderator.employees');
        }
        $moder_id = Auth::user()->employee->department_id;
        if($user_id->employee->department_id == $moder_id){

            // $emp = Employee::where('id', '=', $user_id->employee_id)->first();
            // dd($emp);
            $user_id->employee->update(['name' => $valid['name'], 'surname' => $valid['surname'],
            'patronymic' => $valid['patronymic'], 'faculty' => $valid['faculty'],
            'departament' => $valid['departament'], 'degree' => $valid['degree'],
            'post' => $valid['post']]);

            return redirect()->route('moderator.employees')->with(['successUpdate' => 'Користувач був оновлений']);
        }else{
            return redirect()->route('moderator.employees');
        }
        return redirect()->route('moderator.employees');
    }

    public function requestWork(){

        return view('moderator.request-work');
    }

    public function requestWorkAdd(Request $request){
        // добавление работы
    }

    public function requestWorkRevision(Request $request){
        // отправка сообщения пользователю чтобы он доработал работу
    }

    public function addUser(Request $req){

        $user_dep = IdDepartament::get();
        $req_user = ""; // empty
        $get_req = array(); // empty

        if($req->input('value') && $req->input('type-sort')){
            $val = GetSortUserRequest::sort($req, $user_dep);
            $req_user = $val['value']; $get_req = $val['get'];
        }else{
            $req_user = AccountCreationRequest::where('departament', '=', $user_dep)
            ->with('deg', 'pos')
            ->paginate(15);
        }
        if($req_user->count() == 0){
            return view('moderator.add-user', ['request' => 'Запити відсутні']);
        }else{
            return view('moderator.add-user', compact('req_user', 'get_req'));
        }

        return view('moderator.add-user');
    }

    public function userAdd(Request $request){

       $cheked = AccountCreationRequest::where('id', '=', $request['user_id_req'])->first();
       $user_dep = Auth::user()->employee->departament->id;
       if($cheked->dep->id == $user_dep){
        $employee = new Employee;
        $employee->name = $cheked->name;
        $employee->surname = $cheked->surname;
        $employee->patronymic = $cheked->patronymic;
        $employee->post_id = $cheked->post;
        $employee->degree_id = $cheked->degree;
        $employee->department_id = $cheked->departament;
        try {
            $employee->save();
        } catch (\Throwable $th) {
            return redirect()->route('moderator.addUser');
        }

        $user = new User;

        $user->role_id = 1;
        $user->password = Hash::make($cheked->password_no_hash);
        $user->employee_id = $employee->id;
        $user->email = $cheked->email;
        try {
            $user->save();
        } catch (\Throwable $th) {
            return redirect()->route('moderator.addUser');
        }
        // отправка сообщения

        $to_name = 'TO_NAME';
        $to_email = $cheked->email;
        $data = array('login'=> $cheked->email, "pass" => $cheked->password_no_hash,
            'name' => $cheked->name);

        Mail::send('good-register', $data, function($message) use ($to_name, $to_email){
            $message->to($to_email, $to_name)->subject('Реєстрація в системі');
            $message->from('alekss.yaremko@gmail.com','Wed Ais');
        });

        $cheked->delete();

        return redirect()->route('moderator.addUser');

       }
    }

    public function noAddUser(Request $request){

        try {
            $no_user = AccountCreationRequest::where('id', '=', $request['user_req'])->first();
        } catch (\Throwable $th) {
            return redirect()->route('moderator.addUser');
        }
        if($request['message'] == ""){
            return redirect()->route('moderator.addUser');
        }

        $to_name = 'TO_NAME';
        $to_email = $no_user->email;
        $data = array('mesUser' => $request['message']);

        Mail::send('error-register', $data, function($message) use ($to_name, $to_email){
            $message->to($to_email, $to_name)->subject('Реєстрація в системі');
            $message->from('alekss.yaremko@gmail.com','Wed Ais');
        });

        $no_user->delete();

        return redirect()->route('moderator.addUser');

    }

    public function myMessage(Request $request){
        $user_id = Auth::user()->id;
        $answers = ''; $get_req = array();
        if($request->input('value') && $request->input('type-sort')){
            $val = ModeratorSortMessage::sort($request, $user_id);
            $answers = $val['value']; $get_req = $val['get'];
        }else{
            $answers = FeedbackAnser::where('asked_user', '=', $user_id)
                ->with('user_answered', 'feedback')
                ->paginate(15);
        }

        if($answers->count() == 0){ // записи отсутствуют
            return view('moderator.my-message', ['noMessage' => 'Немає дописів']);
        }else{
            $count_no_read = FeedbackAnser::where([['asked_user_read', '=', false],['asked_user', '=', $user_id]])->count();

            return view('moderator.my-message', compact('answers', 'count_no_read', 'get_req'));
        }

    }

    public function usersQuestion(Request $req){
        $user_dep = Auth::user()->employee->departament->id;
        $user_id = Auth::user()->id;
        $questions = ''; $get_req = array();
        if($req->input('value') && $req->input('type-sort')){
            $val = SortUserQuestion::sort($req, $user_id, $user_dep);
            $questions =$val['value']; $get_req = $val['get'];
        }else{
            $questions = Feedback::where([
                ['user_id', '<>', $user_id],
                ['type_user', '=', 2],
                ['departament_id', '=', $user_dep],
                ['status', '=', false]
            ])
            ->with('user')
            ->paginate(7);
        }

        if($questions->count() == 0){
            return view('moderator.users-question', ['noQuestion' => 'Питань немає']);
        }else{
            return view('moderator.users-question', compact('questions', 'get_req'));
        }

    }

    public function usersQuestionAnswer(Request $request){
        if($request['content'] == ''){
            return redirect()->route('moderator.usersQuestion');
        }
        $feedback = Feedback::where('id', '=', $request['feedback_id'])->first();
        $answer = new FeedbackAnser;
        $answer->feedback_id = $request['feedback_id'];
        $answer->anser = $request['content'];
        $answer->asked_user = $feedback->user_id;
        $answer->answered_user = Auth::user()->id;
        $answer->asked_user_read = false;
        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('feedback', $feedback->user_id);
            $answer->materials = json_encode($json);
        }
        $answer->save();
        $feedback->update(['status' => true]);
        return redirect()->route('moderator.usersQuestion');
    }

    public function works(Request $request){

        $dep_id = Auth::user()->employee->departament->id;
        $works = ""; $get_req = array();
        if($request->input('value') && $request->input('type-sort')){
            $val = SortUserRequestWork::sort($request, $dep_id);
            $works = $val['value']; $get_req = $val['get'];
        }else{
            $works = PlanWork::where('departament_id', '=', $dep_id)
                ->with('work')
                ->paginate(15);
        }

        if($works->count() == 0){ // записи отсутствуют
            return view('moderator.my-works', ['noWorks' => 'Публікації відсутні']);
        }else{
            return view('moderator.my-works', compact('works', 'get_req'));
        }
    }

    public function work($id){

        $user_id = Auth::user()->employee->departament->id;
        $work = PlanWork::where('id', '=', $id)->first();
        if($user_id == $work->departament_id){

            $work_kinds = WorkKind::all();
            $works = Work::all();
            $type_work = TypeWork::all();

            $jsonWork = response()->json($works);
            $jsonWorkKinds = response()->json($work_kinds);
            $jsonTypeWork = response()->json($type_work);

            return view('moderator.work', compact('work', 'works' ,'work_kinds','type_work', 'jsonWork', 'jsonWorkKinds', 'jsonTypeWork'));
        }else{
            return redirect()->route('moderator.works');
        }

    }

    public function deleteWork(Request $request){

        if(!isset($request['work_id'])){
            return redirect()->route('moderator.works');
        }
        $user_id = Auth::user()->employee->departament->id;
        $work = PlanWork::where('id', '=', $request['work_id'])->first();
        if($user_id == $work->departament_id){
            $work->delete();
            return redirect()->route('moderator.works');
        }else{
            return redirect()->route('moderator.works');
        }

    }

    public function editWork(NewWorkRequest $request){
        $valid = $request->validated();

        $work = PlanWork::where('id', '=', $valid['work-id'])->first();
        $user_id = Auth::user()->employee->departament->id;

        if($user_id != $work->departament_id){
            return redirect()->route('moderator.works');
        }

        $itsStatus = false;
        if($valid['status'] == 'yes'){
            $itsStatus = true;
        }

        $newDate = [
            'employee_id' => $work->employee_id,
            'departament_id' => $work->departament_id,
            'work_id' => $work->work_id,
            'academic_year' => $work->academic_year,
            'title' => $valid['work-title'],
            'description' => $valid['desc-work'],
            'norm_semester_1_plan' => $valid['norma-1-plane'],
            'norm_semester_2_plan' => $valid['norma-2-plane'],
            'count_plan' => $valid['count-plane'],
            'percentage_plan' => $valid['share-plane'],
            'norm_semester_1_fact' => $valid['norma-1-fact'],
            'norm_semester_2_fact' => $valid['norma-2-fact'],
            'count_fact' => $valid['count-fact'],
            'percentage_fact' => $valid['share-fact'],
            'status' => $itsStatus
        ];
        try {
            $work->update($newDate);
        } catch (\Throwable $th) {
            return redirect()->route('moderator.work', ['id' => $valid['work-id']])->with(['errorUpdate' => $th->getMessage()]);
        }
        return redirect()->route('moderator.work', ['id' => $valid['work-id']])->with(['successWork' => 'Робота була оновлена']);

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

        return view('moderator.work-add', compact('works' ,'work_kinds','type_work' ,'employee', 'facultyName', 'departamentName', 'year', 'date', 'jsonWork', 'jsonWorkKinds', 'jsonTypeWork'));
    }

    public function newWork(NewWorkRequest $request){
        $valid = $request->validated();

        $work = MakeWorkService::make($valid, true);

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


        return redirect()->route('moderator.addWork')->with(['successWork' => 'Робота додана!']);
    }

    public function feedback(){

        return view('moderator.feedback');
    }

    public function feedbackSend(SendMessageUserRequest $request){

        $validated = $request->validated();

        $message = new Feedback;
        $tema = $validated['tema'];
        $message->title = $tema;
        $message->user_id = Auth::user()->id;
        $message->content = $validated['content'];
        $message->type_user = 3;
        $message->departament_id = Auth::user()->employee->department_id;


        if($request->file('attachment')){
            $files = new AddFileService($request->file('attachment'));
            $json = $files->sendFileToFolder('feedback');
            $message->materials = json_encode($json);
        }
        $message->save();
        return redirect()->route('moderator.feedback')->with(['successFeedback' => 'Ваше повідомлення надіслано.']);

    }

    public function sendMail(){
        $to_name = 'TO_NAME';
        $to_email = 'donnymaster4@gmail.com';
        $data = array('name'=>"Sam Jose", "body" => "Test mail");

        $val = Mail::send('emails', $data, function($message) use ($to_name, $to_email){
            $message->to($to_email, $to_name)->subject('Artisans Web Testing Mail');
            $message->from('alekss.yaremko@gmail.com','Artisans Web');
        });
        dd($val);
    }
}
