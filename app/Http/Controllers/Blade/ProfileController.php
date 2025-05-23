<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        return view('pages.user.profile', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        $user->fill($request->all());
        if ($request->filled('password')){
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('profile');
    }
}
