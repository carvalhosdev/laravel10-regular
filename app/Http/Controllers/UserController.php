<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Password;

class UserController extends Controller
{
   
    public function create(){
        return view('users.register');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('users', 'email')],
            'password' => 'required|confirmed|min:6'
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create($formFields);

        event(new Registered($user));
        
        //login
        auth()->login($user);

        return redirect()->route('verification.notice')
        ->with('maessage', 'Usuário foi criado com sucesso!');
    }

    public function login(){
        return view('users.login');
    }

    public function authenticate(Request $request){
        $formFields = $request->validate([
            'email' => ['required', 'email'],
            'password' => 'required'
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();
            return redirect('/dashboard')->with('message', 'Bem vindo novamente.');
        }

        return redirect("/login")->withErrors([
            'email' => 'Credenciais inválidas'
        ])->onlyInput('email');
    }

    public function logout(Request $request){
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect("/login")->with('message', 'Você saiu do sistema');
    }

    public function forgot(){
        return view("users.forgot-password");
    }
    
    public function recover(Request $request){
        $request->validate([
            'email' => 'required|email'
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                ? back()->with(['message' => __($status)])
                : back()->withErrors(['message' => __($status)]);
    }

    public function reset(Request $request, string $token){
        return view('users.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }

    public function updatePasword(Request $request){
        $formFields = $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $status = Password::reset($formFields, function(User $user, string $password){
            $user->forceFill([
                'password' => bcrypt($password)
            ]);

            $user->save();

            event(new PasswordReset($user));
        });

        return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('message', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
