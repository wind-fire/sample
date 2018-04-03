<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //身份认证
    public function __construct()
    {
        $this->middleware('auth',[
            'except' => ['show','create','store','index']
        ]);

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }


    //创建用户页面
    public function create()
    {
        return view('users.create');
    }

    // resource 资源
    public function show(User $user)
    {
        // $user 通过 compact 方法转化为一个关联数组，并作为第二个参数传递给 view 方法，将数据与视图进行绑定。
        return view('users.show',compact('user'));
    }

    //用户注册
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);


    //  注册后自动登录
        Auth::login($user);
        session()->flash('success','欢迎，您将在这里开启一段新的旅程');
        return redirect()->route('users.show',[$user]);
    }

    //编辑用户信息

    public function  edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit',compact('user'));
    }

    public function update(User $user,Request $request)
    {
        $this->validate($request,[
            'name' =>'required|min:3|max:50',
            'password' =>'nullable|confirmed|min:6'
        ]);

        $this->authorize('update', $user);
        /*$user->update([
            'name' => $request->name,
            'password' =>$request->password
        ]);*/

        $data =[];
        $data['name'] = $request->name;

        if ($request->password)
        {
            $data['password'] =bcrypt($request->password);
        }

        $user->update($data);



        session()->flash('success','个人资料更新成功');
        return redirect()->route('users.show',$user->id);

    }
    //用户列表
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));

    }
    //删除用户
    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户！');
        return back();
    }



}
