<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function store(Request $request)
    {
    }

    public function fetch(Request $request)
    {
        $user = $request->user();

        return view('profile')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($request->input('email') == $user->email) {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
            ]);
        } else {

            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
            ]);
        }




        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email')
        ]);

        return redirect('home');
    }
}
