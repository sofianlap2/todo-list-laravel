<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

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

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role == "admin") {
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

        if ($validator->fails()) {
            return redirect()->route('register.index')->withErrors($validator);
        }

        $image = $request->file('file_image');
        if ($image != null && !$image->getError()) {
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

    public function getProfile(string $id)
    {
        $user = User::whereId($id)->first();
        return view('auth/profile', compact('user'));
    }

    public function updateProfile(Request $request, string $id)
    {
        $user = User::whereId($id)->first();

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:4'],
            'email' => $request->get('email') !== $user->email ? ['required', 'email', 'unique:users'] : ['required', 'email'],
            'file_image' => ['image', 'max:5000']
        ]);

        if ($validator->fails()) {
            return redirect()->route('profile.getProfile', ['id' => $id])->withErrors($validator);
        }

        $image = $request->file('file_image');
        if ($image !== null && !$image->getError()) {
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

    public function forgotPasswordIndex()
    {
        return view('auth.forgot-password');
    }

    public function forgotPasswordSend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
