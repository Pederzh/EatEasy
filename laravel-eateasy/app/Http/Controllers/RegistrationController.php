<?php namespace App\Http\Controllers;

use App\User;
use App\Mailers\AppMailer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegistrationController extends Controller
{
    /**
     * Create a new registration instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Show the register page.
     *
     * @return \Response
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Perform the registration.
     *
     * @param  Request   $request
     * @param  AppMailer $mailer
     * @return \Redirect
     */
    public function postRegister(Request $request, AppMailer $mailer)
    {
        $this->validate($request, [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:6'
        ]);

        if (isset($request['check_esercente']) && $request['check_esercente'] == 'on' )
            $var = 1 ;
        else
            $var = 0 ;

        $user = User::create([
            'email' => $request['email'],
            'password' => $request['password'],
            'esercente' => $var
        ]);

        $mailer->sendEmailConfirmationTo($user);

        $success = "Abbiamo mandato una e-mail di conferma all'indirizzo indicato";
        //return redirect()->back()->with(['success' => "Abbiamo mandato una e-mail di conferma all'indirizzo indicato"]);
        return view('auth.register', compact('success'));
    }

    /**
     * Confirm a user's email address.
     *
     * @param  string $token
     * @return mixed
     */
    public function confirmEmail($token)
    {
        User::whereToken($token)->firstOrFail()->confirmEmail();

        return redirect('login');
    }
}
