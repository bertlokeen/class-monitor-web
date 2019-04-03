<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Validator;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::orderBy('created_at', 'desc')->with('user')->paginate(20);

        return view('admins.index', compact('admins'));
    }

    public function create()
    {
        return view('admins.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }

        $user = User::create([
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => $request->get('date_of_birth'),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        $admin = Admin::create([
            'user_id' => $user->id,
            'bio' => $request->get('bio')
        ]);

        $user->assignRole('admin');

        return redirect()->route('admin.show', $admin->id)->with('status', 'success');
    }

    public function show(Admin $admin)
    {
        return view('admins.show', compact('admin'));
    }
    
    public function edit(Admin $admin)
    {
        return view('admins.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|', Rule::unique('users')->ignore($admin->user->id),
            'password' => $request->filled('password') ? 'string|min:6|confirmed' : '',
            'first_name' => 'required|min:2|max:255',
            'middle_name' => 'max:255',
            'last_name' => 'required|min:2|max:255'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator->errors())->withInput();
        }
        
        $admin->user->update([
            'email' => $request->get('email'),
            'first_name' => $request->get('first_name'),
            'middle_name' => $request->get('middle_name'),
            'last_name' => $request->get('last_name'),
            'address' => $request->get('address'),
            'father_name' => $request->get('father_name'),
            'mother_name' => $request->get('mother_name'),
            'date_of_birth' => $request->get('date_of_birth'),
            'place_of_birth' => $request->get('place_of_birth')
        ]);

        if($request->filled('password')) {
            $admin->user->update(['password' => Hash::make($request->get('password'))]);
        }

        $admin->update([
            'bio' => $request->get('bio')
        ]);

        return redirect()->route('admin.show', $admin->id)->with('status', 'success');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();

        return redirect()->route('admin.index')->with('status', 'success');
    }
}
