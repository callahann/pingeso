<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\User;

class GoogleLoginController extends Controller
{
    private $email = 'mail';
    
    public function redirectToProvider()
    {
        return Auth::check() ?
            redirect()->route('inicio') :
            Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->stateless()->user();
        $findUser = User::where('email', $user->getEmail())->first();
        if($findUser){
            $this->email = $user->getEmail();
            Auth::login($findUser);
            return redirect()->route('inicio');
        }
        else{
            return redirect()->route('no-registrado');
        }
    }
}
