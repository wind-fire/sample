<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    //用户登录页面
    public function create()
    {
        return view('sessions.create');
    }
    // 用户登录认证
    public function store(Request $request)
    {
        $credentials = $this->validate($request,[
            'email' => 'required|email|max:255',
            'password' =>'required'
        ]);

       
        if(Auth::attempt($credentials,$request->has('remember')))
        {
            session()->flash('success','欢迎回来！');
//            return redirect()->route('users.show' , [Auth::user()]);
            return redirect()->route('users.show', [Auth::user()]);
        }else{
            session()->flash('danger','很抱歉，你的邮箱和密码不匹配');
            return redirect()->back();
        }

    }

    //用户注销
    public function destroy()
    {
        Auth::logout();
        session()->flash('success','您已成功退出');
        return redirect('login');
    }
}