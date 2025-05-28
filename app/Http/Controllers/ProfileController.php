<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class ProfileController extends Controller
{
    private const PAGINATE_SIZE = 5;

    // Función para devolver a la página principal del elemento
    public function index()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $profiles = Profile::paginate(self::PAGINATE_SIZE);
        return Inertia::render('Profile/Index', ['profiles' => $profiles,'langTable' => fn () => Lang::get('tableProfiles'),]);
    }

    // Show the form for creating a new profile
    public function create()
    {
        return Inertia::render('Profile/Form');
    }

    // Store a newly created profile in storage
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'nullable|string|max:100',
            'surname' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $profile = new Profile();
        $profile->user_id = $request->user_id;
        $profile->name = $request->name;
        $profile->surname = $request->surname;
        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->phone = $request->phone;
        $profile->save();

        return redirect()->route('profiles.index');
    }

    // Display the specified profile
    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        return Inertia::render('Profile/Show', ['profile' => $profile]);
    }

    // Show the form for editing the specified profile
    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return Inertia::render('Profile/Form', ['profile' => $profile]);
    }

    // Update the specified profile in storage
    public function update(Request $request, $id)
    {
        $profile = Profile::findOrFail($id);

        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'name' => 'nullable|string|max:100',
            'surname' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $profile->user_id = $request->user_id;
        $profile->name = $request->name;
        $profile->surname = $request->surname;
        $profile->country = $request->country;
        $profile->city = $request->city;
        $profile->phone = $request->phone;
        $profile->save();

        return redirect()->route('profiles.index');
    }

    // Remove the specified profile from storage
    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index');
    }

    public function myProfileShow()
    {
        app()->setLocale(session('locale', app()->getLocale()));

        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $profile = $user->profile ?? Profile::where('user_id', $user->id)->firstOrFail();
        return Inertia::render('MyProfile/Show', [
            'lang' => function () {
                return Lang::get('general');
            },
            'auth' => [
                'user' => Auth::user(),
            ],
            'appName' => config('app.name'),
            'locale' => session('locale', app()->getLocale()),
            'profile' => $profile
        ]);
    }
    public function myProfileEdit()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }
        $profile = $user->profile ?? Profile::where('user_id', $user->id)->firstOrFail();
        return Inertia::render('MyProfile/Form', [
            'lang' => function () {
                return Lang::get('general');
            },
            'auth' => [
                'user' => Auth::user(),
            ],
            'appName' => config('app.name'),
            'locale' => session('locale', app()->getLocale()),
            'profile' => $profile
        ]);
    }
}
