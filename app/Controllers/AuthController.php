<?php


namespace App\Controllers;

use App\Models\User;
use Core\Support\Auth;
use Core\Validation\Validator;

class AuthController
{

    public function signup()
    {

        return view('auth.signup', 'AuthLayout');
    }

    public function doSignup()
    {

        $rules = [
            'email' => 'required|email|unique:users,email',
            'name' => 'required|between:4,10',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ];
        $aliases = ['password_confirmation' => 'Password Confirmation'];

        $validator = new Validator();

        $validator->make(request()->all(), $rules, $aliases);

        if ($validator->fails())
        {
            session()->setFlash('errors', $validator->errors());
            session()->setFlash('old', request()->all());
            return back();
        }

        $userData = request()->except('password_confirmation');
        $userData['password'] = bcrypt(request('password'));

        User::create($userData);

        Auth::login($userData);

        return redirect('/');
    }

    public function login()
    {

        return view('auth.login', 'AuthLayout');
    }

    public function doLogin()
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
        $aliases = ['password_confirmation' => 'Password Confirmation', 'email' => 'Email'];

        $validator = new Validator();
        $validator->make(request()->all(), $rules, $aliases);

        if ($validator->fails())
        {
            session()->setFlash('errors', $validator->errors());
            session()->setFlash('old', request()->all());
            return back();
        }

        if (!Auth::attempt(request()->only('email', 'password')))
        {
            session()->setFlash('messages', ['Credientials are incorrect.']);
            return back();
        }
        return redirect('/');
    }

    public function doLogout()
    {
        Auth::logout();

        return redirect('/login');
    }
}
