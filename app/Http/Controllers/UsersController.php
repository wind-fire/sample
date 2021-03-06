<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //身份认证
    public function __construct()
    {
        $this->middleware('auth',[
<<<<<<< HEAD
            'except' => ['show','create','store','index','confirmEmail']
=======
//            'except' => ['show','create','store','index']
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
>>>>>>> 1c2cf040c24fdc3a6c617d94ea08d2ee165f9117
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
//        return view('users.show',compact('user'));

        /*compact 方法可以同时接收多个参数，
        在上面代码我们将用户数据 $user 和微博动态数据 $statuses 同时传递给用户个人页面的视图上。*/
        $statuses = $user->statuses()
                        ->orderBy('created_at', 'desc')
                        ->paginate(30);
        return view('users.show', compact('user', 'statuses'));
    }

    //用户注册
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱上，请注意查收。');
        return redirect('/');

    }

    //发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });
    }

    //确认邮件
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

<<<<<<< HEAD
=======
    //  注册后自动登录
//        Auth::login($user);

        /*注册成功后发送激活邮件*/
        $this->sendEmailConfirmationTo($user);
        session()->flash('success','验证邮件已发送到你的注册邮箱上，请注意查收。');
//        return redirect()->route('users.show',[$user]);
        return redirect('/');
    }


    //发送邮件
    protected function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'aufree@yousails.com';
        $name = 'Aufree';
        $to = $user->email;
        $subject = "感谢注册 Sample 应用！请确认你的邮箱。";

        /*Mail::send($view, $data, function ($message) use ($from, $name, $to, $subject) {
            $message->from($from, $name)->to($to)->subject($subject);
        });*/

        Mail::send($view, $data, function ($message) use ($to, $subject) {
            $message->to($to)->subject($subject);
        });
    }

    /*邮件链接激活用户*/
    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();

        $user->activated = true;
        $user->activation_token = null;
        $user->save();

>>>>>>> 1c2cf040c24fdc3a6c617d94ea08d2ee165f9117
        Auth::login($user);
        session()->flash('success', '恭喜你，激活成功！');
        return redirect()->route('users.show', [$user]);
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

    /*关注的人*/
    public function followings(User $user)
    {
        $users = $user->followings()->paginate(30);
        $title = '关注的人';
        return view('users.show_follow', compact('users', 'title'));
    }

    /*粉丝*/
    public function followers(User $user)
    {
        $users = $user->followers()->paginate(30);
        $title = '粉丝';
        return view('users.show_follow', compact('users', 'title'));
    }


}
