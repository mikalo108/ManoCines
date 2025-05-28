<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Inertia\Inertia;
use Illuminate\Support\Facades\Lang;

class UserController extends Controller
{
    private const PAGINATE_SIZE = 5;

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = User::query();

        if ($request->filled('userId')) {
            $query->where('id', $request->userId);
        }

        if ($request->filled('username')) {
            $query->where('name', 'like', '%' . $request->username . '%');
        }

        if ($request->filled('email')) {
            $query->where('email', 'like', '%' . $request->email . '%');
        }

        if ($request->filled('role')) {
            $query->where('role', 'like', '%' . $request->role . '%');
        }

        $users = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('User/Index', [
            'users' => $users,
            'langTable' => fn () => Lang::get('tableUsers'),
            'fieldsCanFilter' => [
                ['key' => 'userId', 'field' => $request->userId],
                ['key' => 'username', 'field' => $request->username],
                ['key' => 'email', 'field' => $request->email],
                ['key' => 'role', 'field' => $request->role],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('User/Form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|max:255',
            'surname' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->role = $request->role ?? 'client'; // Default role is 'client'
        $user->save();

        $user->profile()->create([
            'name' => $request->name,
            'surname' => $request->surname,
            'country' => $request->country,
            'city' => $request->city,
            'phone' => $request->phone,
        ]);

        return redirect()->route('users.index');
    }

    public function show($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('User/Show', ['user' => $user]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return Inertia::render('User/Form', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'nullable|string|max:255',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->role = $request->role ?? $user->role;
        $user->save();

        return redirect()->route('users.index');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index');
    }
}
