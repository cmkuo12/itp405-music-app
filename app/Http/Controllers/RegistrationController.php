<?php



namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index()
    {
        return view('auth.register'); //form to create account
    }

    public function register(Request $request) //creation of user accounts
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); //bcrypt algorithm; don't store in raw form, encryt in database
        $user->save();

        Auth::login($user); //creates session with user; don't need to use start_session function

        return redirect()->route('profile.index');
    }
}
