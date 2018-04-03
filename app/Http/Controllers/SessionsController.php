<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{
    public function __construct()
    {

        $this->middleware('guest', [
            'only' => ['create']
        ]);
    }
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
//            return redirect()->route('users.show', [Auth::user()]);
            /*redirect() 实例提供了一个 intended 方法，该方法可将页面重定向到上一次请求尝试访问的页面上，
            并接收一个默认跳转地址参数，当上一次请求记录为空时，跳转到默认地址上*/
            return redirect()->intended(route('users.show', [Auth::user()]));
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
