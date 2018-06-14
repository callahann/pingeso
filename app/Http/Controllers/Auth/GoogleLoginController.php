<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\User;

class GoogleLoginController extends Controller
{
    
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $findUser = User::where('email', $user->getEmail())->first();
        if($findUser){
            
            return view('spa');
        }
        else{
            return 'No estás registrado en la aplicación';
        }
    }

    public function getUserEmail(){
        $user = Socialite::driver('google')->stateless()->user();
        return $user->email;
    }
}
