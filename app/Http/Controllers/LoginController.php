<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        // Auth::viaRemember();
    }


    protected $username;

    function index()
    {
        return view('login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function authenticate(Request $request)
    {
        //find the field type and attempt login on that field
        $input_type = $this->findUsername();

        //set the table column that should attempt to login based on user requested input type
        $this->username =  $input_type;

        $credentials = $request->only($input_type, 'password');
        $remember_me = $request->has('remember') ? true : false;

        $login = Auth::Attempt($credentials, $remember_me);

        if ($login) {
            // Authentication passed...
            return  redirect()->route('home');
        } else {
            $errors = ['wrong ' . $input_type . ' or password.'];
            return redirect('/')->withErrors($errors);
        }
    }




    function logout()
    {

        Auth::logout();
        return redirect(\url()->previous());
    }






    /**
     * Get the login username to be used by the controller.
     * bellow method will validate request and filter the
     * request email field to check whether it is email or
     * username to try attemt login to that field 
     * @return string
     */
    public function findUsername()
    {
        $login = request()->input('email');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$fieldType => $login]);


        if ($fieldType === 'email') {
            $this->validate(request(), [
                'email' => 'bail|required|max:100|email',
                'password' => 'required|max:50|min:8'
            ]);

            return $fieldType;
        } else {
            $this->validate(request(), [
                'username' => 'bail|required|max:100',
                'password' => 'required|max:50|min:8'
            ]);

            return $fieldType;
        }
    }

    /**
     * Get username property.
     * this will set field that login should attemp email/username
     * @return string
     */

    public function username()
    {
        return $this->username;
    }
}
