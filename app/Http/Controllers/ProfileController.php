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

        if ($request->filled('country')) {
            $query->where('country', 'like', '%' . $request->country . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
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
                ['key' => 'country', 'field' => $request->country],
                ['key' => 'phone', 'field' => $request->phone],
            ],
        ]);
    }

    public function create()
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $users_lastID = \App\Models\User::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Profile/Form', [
         'dataControl' => [
                ['key' => 'user_id', 'field' => '', 'type' => 'number', 'posibilities' => $users_lastID],
                ['key' => 'name', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'surname', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'country', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'city', 'field' => '', 'type' => 'text', 'posibilities' => ''],
                ['key' => 'phone', 'field' => '', 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'name' => 'nullable|string|max:100',
            'surname' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        $validation = Profile::where('user_id', $request->user_id);
        if ($validation->exists()) {
            return redirect()->back()
                ->withErrors(['profile' => 'Ya existe una relación con esta User ID.'])
                ->withInput();
        }

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

    public function edit($id)
    {
        app()->setLocale(session('locale', app()->getLocale()));  
        $profile = Profile::findOrFail($id);
        $users_lastID = \App\Models\User::orderBy('id', 'desc')->first()?->id;

        return Inertia::render('Profile/Form', [
         'profile' => $profile,
         'dataControl' => [
                ['key' => 'user_id', 'field' => $profile->user_id, 'type' => 'number', 'posibilities' => $users_lastID],
                ['key' => 'name', 'field' => $profile->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'surname', 'field' => $profile->surname, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'country', 'field' => $profile->country, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'city', 'field' => $profile->city, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'phone', 'field' => $profile->phone, 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'surname' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        
        $profile = Profile::findOrFail($id);

        if($request->user_id){
            $validation = Profile::where('user_id', $request->user_id);
            if ($validation->exists() && $validation->id != $id) {
                return redirect()->back()
                    ->withErrors(['profile' => 'Ya existe una relación con esta User ID.'])
                    ->withInput();
            }
            
            $profile->user_id = $request->user_id;
        }
        
        if($request->name){
            $profile->name = $request->name;
        }
        if($request->name){
            $profile->surname = $request->surname;
        }
        if($request->name){
            $profile->country = $request->country;
        }
        if($request->name){
            $profile->city = $request->city;
        }
        if($request->name){
            $profile->phone = $request->phone;
        }

        $profile->save();

        return redirect()->route('profiles.index');
    }

    public function updateMyProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'nullable|string|max:100',
            'surname' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
        ]);

        
        $profile = Profile::findOrFail($id);

        if($request->user_id){
            $validation = Profile::where('user_id', $request->user_id);
            if ($validation->exists() && $validation->id != $id) {
                return redirect()->back()
                    ->withErrors(['profile' => 'Ya existe una relación con esta User ID.'])
                    ->withInput();
            }
            
            $profile->user_id = $request->user_id;
        }
        
        

        $profile->save();

        return redirect()->route('dashboard');
    }

    public function destroy($id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index');
    }

    public function myProfile()
    {
        app()->setLocale(session('locale', app()->getLocale()));

        if (!Auth::user()) {
            abort(403, 'Unauthorized');
        }

        $profile = Profile::where('user_id', Auth::user()->id)->first();

        // Si no existe, lo creamos vacío
        if (!$profile) {
            $profile = new Profile();
            $profile->user_id = Auth::user()->id;
            $profile->name = '';
            $profile->surname = '';
            $profile->country = '';
            $profile->city = '';
            $profile->phone = '';
            $profile->save();
        }

        return Inertia::render('Profile/MyProfile', [
         'profile' => $profile,
         'dataControl' => [
                ['key' => 'name', 'field' => $profile->name, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'surname', 'field' => $profile->surname, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'country', 'field' => $profile->country, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'city', 'field' => $profile->city, 'type' => 'text', 'posibilities' => ''],
                ['key' => 'phone', 'field' => $profile->phone, 'type' => 'text', 'posibilities' => ''],
            ],
        ]);
    }
}
