<?php

namespace App\Http\Controllers\Blade;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->paginate(10);

        return view('pages.user.index', compact('users'));
    }

    public function create()
    {
        return view('pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        message_set('Пользователь создан успешно', 'success');
        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::where('id', $id)
            ->where('id', '!=', auth()->user()->id)
            ->first();

        if (!$user) {
            message_set('Пользователь не найден', 'error');
            return redirect()->route('users.index');
        }

        $user->delete();

        message_set('Пользователь удален успешно', 'success');
        return redirect()->route('users.index');
    }
}
