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
use App\Http\Requests\UserInsertRequest;
use App\AccountCreationRequest;

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
        $validated['password_no_hash'] = str_random(14);
        $userRequest = new AccountCreationRequest($validated);
        $userRequest->save();

        if(false){
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
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

        return view('user.account', compact('user'));
    }

    public function myWorks(){
        return view('user.my-works');
    }
    public function addWork(){
        return view('user.add-work');
    }
    public function feedback(){
        return view('user.feedback');
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
}
