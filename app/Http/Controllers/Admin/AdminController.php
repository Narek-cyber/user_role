<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendInviteJob;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AdminController extends Controller
{
    /**
     * @return View|Factory|Application
     */
    public function index(): View|Factory|Application
    {
        $users = User::query()->where('role', 'user')->paginate(15);
        return view(
            'admin.users',
            compact('users')
        );
    }

    /**
     * @param Request $request
     * @param $id
     * @return RedirectResponse
     */
    public function inviteUser(Request $request, $id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);
        $invite_token = Str::random(64);
        $invite_link = route('user.invite', [$invite_token]);

        $user->update([
            'invite_link' => $invite_link,
            'invite_token' => $invite_token,
        ]);

        $email = $user->{'email'};

        dispatch(new SendInviteJob($email, $invite_link));

        return redirect()->back();
    }

    /**
     * @param $token
     * @return Factory|View|Application|void
     */
    public function invite($token)
    {
        $user = User::query()->where('invite_token', $token)->get()->first();
        if ($user && $user->{'invite_token'} == $token && $user->{'invited'} == 0) {
            $user->update(['invited' => true]);
            return view('user.invited_user_login', compact('token'));
        }
        abort(404);
    }

    /**
     * @param Request $request
     * @param $token
     * @return RedirectResponse
     */
    public function invitedUserLogin(Request $request, $token): RedirectResponse
    {
        $user = User::query()->where('invite_token', $token)->get()->first();
        $request->validate([
            'password' => ['required', Rules\Password::defaults()],
        ]);

        if ($user && Hash::check($request->input('password'), $user->password)) {
            Auth::login($user);
            return redirect()->intended('dashboard')->with('success', 'Login successful!');
        }

        return redirect()->back()->with('error', 'Login failed!');
    }
}
