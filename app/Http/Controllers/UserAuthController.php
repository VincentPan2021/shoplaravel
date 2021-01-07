<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Hash;
use Mail;
use DB;
use App\Shop\Entity\User;
use App\Jobs\SendSignUpMailJob;

class UserAuthController extends Controller
{
    //SignUpPage
    public function SignUpPage(){
        $binding = [
            'title' => '會員註冊'
        ];

        return view('auth.SignUp', $binding);
    }

    //SignUpProcess
    public function SignUpProcess(){
        $input = request()->all();
        //var_dump($input); exit;
        
        $rules = [
            'nickname' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email'],
            'password' => ['required', 'min:6', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'min:6'],
            'type' => ['required', 'in:A,G'],
        ];

        //validation
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            //var_dump($validator->errors()); exit;
            return redirect('/user/auth/sign-up')
                    ->withErrors($validator)
                    ->withInput();
        }

        //password hash
        $input['password'] = Hash::make($input['password']);
        //var_dump($input);

        //insert user data
        $Users = User::create($input);

        //mail to user
        $mail_binding = [
            "nickname" => $input["nickname"],
            "email" => $input["email"],
        ];

        /////dispatch SendSignUpMailJob
        SendSignUpMailJob::dispatch($mail_binding);
        
        return redirect('/user/auth/sign-in');
    }

    //SignInPage
    public function SignInPage(){
        $binding = [
            'title' => '會員登入'
        ];

        return view('auth.SignIn', $binding);
    }

    //SignInProcess
    public function SignInProcess(){
        $input = request()->all();
        //var_dump($input); exit;
        
        $rules = [
            'email' => ['required', 'max:50', 'email'],
            'password' => ['required', 'min:6'],
        ];

        //validation
        $validator = Validator::make($input, $rules);

        if($validator->fails()){
            //var_dump($validator->errors()); exit;
            return redirect('/user/auth/sign-in')
                    ->withErrors($validator)
                    ->withInput();
        }

        //DB::enableQueryLog();

        $User = User::where('email', $input['email'])->firstOrFail();

        //var_dump(DB::getQueryLog()); exit;

        $is_correct = Hash::check($input['password'], $User->password);

        if(!$is_correct){
            $error_message = [
                'msg' => ['登入失敗!']
            ];

            return redirect('/user/auth/sign-in')
                    ->withErrors($error_message)
                    ->withInput();
        }

        session()->put('user_id', $User->id);

        return redirect()->intended("/");
    }

    //SignOut
    public function SignOut(){
        session()->forget('user_id');

        return redirect('/user/auth/sign-in');
    }

}
