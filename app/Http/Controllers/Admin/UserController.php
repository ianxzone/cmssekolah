<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::excludeSuperAdmin()->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $roles = User::getRolesList();
        // Remove superadmin from the dropdown if the current user is not a superadmin
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            unset($roles[User::ROLE_SUPERADMIN]);
        }
        return view('admin.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
                $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'role' => 'required|string',
            'job_title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        $avatarPath = null;
        if ($request->filled('avatar')) {
            $avatarPath = str_replace(url('/storage') . '/', '', $request->input('avatar'));
            $avatarPath = str_replace('/storage/', '', $avatarPath);
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->has('is_active'),
            'job_title' => $request->job_title,
            'phone' => $request->phone,
            'bio' => $request->bio,
            'avatar' => $avatarPath,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'linkedin_url' => $request->linkedin_url,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $roles = User::getRolesList();
        if (auth()->check() && !auth()->user()->isSuperAdmin()) {
            unset($roles[User::ROLE_SUPERADMIN]);
        }
        return view('admin.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
                $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => ['nullable', 'string', 'confirmed', \Illuminate\Validation\Rules\Password::min(8)->letters()->mixedCase()->numbers()->symbols()],
            'job_title' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:50',
            'bio' => 'nullable|string|max:1000',
            'avatar' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->is_active = $request->has('is_active');
        
        $user->job_title = $request->job_title;
        $user->phone = $request->phone;
        $user->bio = $request->bio;
        
        if ($request->filled('avatar')) {
            $avatarPath = str_replace(url('/storage') . '/', '', $request->input('avatar'));
            $avatarPath = str_replace('/storage/', '', $avatarPath);
            $user->avatar = $avatarPath;
        } elseif ($request->has('avatar') && empty($request->input('avatar'))) {
            $user->avatar = null;
        }

        $user->facebook_url = $request->facebook_url;
        $user->twitter_url = $request->twitter_url;
        $user->instagram_url = $request->instagram_url;
        $user->linkedin_url = $request->linkedin_url;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')->withErrors(['error' => 'Anda tidak bisa menghapus diri sendiri.']);
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus.');
    }
}

