<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Carbon\Carbon;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'registerEmail' => 'required|email|max:255|unique:users,email',
            'registerPassword' => 'required|min:6|alpha_dash',
            'privacyPolicy' => 'required'
        ];
        $messages = [
            'name.required' => 'Имя обязателен к заполнению',
            'name.string' => 'Имя должно быть строкой',
            'name.max' => 'Имя не должно содержать больше :max символов',
            'registerEmail.unique' => 'Email уже существует',
            'registerEmail.required' => 'Email обязателен к заполнению',
            'registerEmail.email' => 'Введенный email некорректен',
            'registerEmail.max' => 'Email не должен содержать больше :max символов',
            'registerPassword.required' => 'Пароль обязателен к заполнению',
            'registerPassword.min' => 'Пароль должен содержать :min и больше символов',
            'registerPassword.alpha_dash' => 'Пароль может содержать только буквы, цифры и точки',
        ];

        return Validator::make($data, $rules, $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['registerEmail'];
        $user->password = bcrypt($data['registerPassword']);
        $user->subscribed = isset($data['subscribe']);
        $user->last_visit = Carbon::now();
        $user->save();
        return $user;
    }
}
