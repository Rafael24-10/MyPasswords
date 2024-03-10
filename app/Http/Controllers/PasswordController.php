<?php

namespace App\Http\Controllers;

use App\Models\Password;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;


class PasswordController extends Controller
{
    private $encryption_key;

    public function __construct()
    {
        $this->middleware('auth');
    }


    private function getEncryptionKey($user)
    {
        return Crypt::decryptString($user->encryption_key, env('ENCRYPTION_KEY'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'password_name' => 'required|string|max:40',
            'password_value' => 'required|string|max:255',
        ]);

        $user = $request->user();
        $encryption_key = $this->getEncryptionKey($user);

        $user->passwords()->create([
            'password_name' => $request->input('password_name'),
            'password_value' => Crypt::encryptString($request->input('password_value'), $encryption_key),
        ]);

        return redirect()->route('home');
    }



    public function index(Request $request)
    {
        $user = $request->user();
        $passwords = Password::where('user_id', $user->id)->get()->map(function ($password) {
            return [
                'password_id' => $password->password_id,
                'password_name' => $password->password_name,
                'password_value' => Crypt::decryptString($password->password_value, $this->encryption_key)
            ];
        });

        return view('home')->with('passwords', $passwords);
    }


    public function destroy($password_id)
    {
        $password = Password::find($password_id);
        $password->delete();
        return redirect()->route('home');
    }


    public function update(Request $request, $password_id)
    {
        $password = Password::findOrFail($password_id);

        $request->validate([
            'new_password_name' => 'required|string|max:40',
            'new_password_value' => 'required|string|max:355',
        ]);



        $password_value = Crypt::encryptString($request->input('new_password_value'), $this->encryption_key);

        $password->update([
            'password_name' => $request->input('new_password_name'),
            'password_value' => $password_value,
        ]);


        return redirect()->route('home');
    }
}
