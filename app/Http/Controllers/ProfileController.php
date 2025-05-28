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

    public function index(Request $request)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $query = Profile::query();

        if ($request->filled('profileId')) {
            $query->where('id', $request->profileId);
        }

        if ($request->filled('userId')) {
            $query->where('user_id', $request->userId);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('surname')) {
            $query->where('surname', 'like', '%' . $request->surname . '%');
        }

        $profiles = $query->orderBy('id', 'desc')->paginate(self::PAGINATE_SIZE);
        return Inertia::render('Profile/Index', [
            'profiles' => $profiles,
            'langTable' => fn () => Lang::get('tableProfiles'),
            'fieldsCanFilter' => [
                ['key' => 'profileId', 'field' => $request->profileId],
                ['key' => 'userId', 'field' => $request->userId],
                ['key' => 'name', 'field' => $request->name],
                ['key' => 'surname', 'field' => $request->surname],
            ],
        ]);
    }

    public function create()
    {
        return Inertia::render('Profile/Form');
    }

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

    public function show($id)
    {
        $profile = Profile::findOrFail($id);
        return Inertia::render('Profile/Show', ['profile' => $profile]);
    }

    public function edit($id)
    {
        $profile = Profile::findOrFail($id);
        return Inertia::render('Profile/Form', ['profile' => $profile]);
    }

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
