<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SecondTodo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth/register');
    }

    public function loginIndex()
    {
        return view('auth/login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if(Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if(Auth::user()->role == "admin") {
                return redirect()->intended(route('todos.index'));
            } else {
                return redirect()->intended(route('todo.index'));
            }
        }

        return to_route('login.loginIndex')->withErrors([
            'email' => 'The credentials are incorrect',
        ])->onlyInput('email');
    }

    public function inscription(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:4'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required'],
            'file_image' => ['image', 'max:5000']
        ]);

        if($validator->fails()) {
            return redirect()->route('register.index')->withErrors($validator);
        }

        $image = $request->file('file_image');
        if($image != null && !$image->getError()) {
            $imagePath = $image->store('blog', 'public');
        } else {
            $imagePath = "";
        }

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'image' => $imagePath
        ]);

        return redirect()->route('login.loginIndex');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.loginIndex');
    }

    public function getProfile(string $id) {
        $user = User::whereId($id)->first();
        return view('auth/profile', compact('user'));
    }

    public function updateProfile(Request $request, string $id) {
        $user = User::whereId($id)->first();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:4'],
            'email' => $request->get('email') !== $user->email ? ['required', 'email', 'unique:users'] : ['required', 'email'],
            'file_image' => ['image', 'max:5000']
        ]);

        if($validator->fails()) {
            return redirect()->route('profile.getProfile', ['id' => $id])->withErrors($validator);
        }

        $image = $request->file('file_image');
        if($image !== null && !$image->getError()){
            $basePath = $image->store('blog', 'public');
        } else {
            $basePath = "";
        }

        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->image = $basePath;

        $user->save();

        return redirect()->route('profile.getProfile', ['id' => $id])->with('success', 'user updated');
    }
}
