<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminUserController extends Controller
{
    public function index($users = null)
    {   
        if (is_null($users)) {
            $users = User::oldest();
        }

        $props = [
            'users' => $users->paginate(10)
        ];

        return view('admin.users', ['props' => $props]);
    }

    public function filter()
    {   
        $users = User::oldest();

        if(request('sort_by_time') == 'latest') {
            $users = User::latest();
        }

        if(request('search')) {
            $users->where('name', 'like', '%' . request('search') . '%');
        }

        if(request('filter_role')) {
            $users->where('role', 'like', '%' . request('filter_role') . '%');
        }

        return $this->index($users);
    }

    public function store()
    {   
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255',
            'role' => 'required'
        ]);

        $attributes['role'] = $attributes['role'] * 1;
        if (!(User::where('username', $attributes['username'])->get()->count() > 0)) {
            User::create($attributes);
            return redirect('/admin/users')->with('success', 'New user added');
        } else {
            return redirect('/admin/users')->with('failed', 'Username or Email is already existed');
        }
    }

    // public function edit(User $user)
    // {
    //     $props = [
    //         'user' => $user
    //     ];
    //     return view('admin.edit-user', [
    //         'props' => $props
    //     ]);
    // }

    public function update(User $user)
    {
        $attributes = request()->validate([
            'name' => 'required|max:255',
            'username' => 'required|max:255|min:3',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8|max:255',
            'role' => 'required|integer'
        ]);

        $attributes['role'] = $attributes['role'] * 1;
        $user->update($attributes);
        return redirect("/admin/users")->with('success', 'Your changes have been saved');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 1) {
            $user->delete();
            return redirect('/admin/users')->with('success', 'User deleted');
        } else {
            return redirect('/admin/users')->with('failed', 'Can\'t delete protected record');
        }
    }

    public function destroyAll(Request $request)
    {
        $selectedUsers = $request->input('selected', []);
        
        $users = User::whereIn('id', $selectedUsers)->get();

        $flag = 0;
        foreach ($users as $user) {
            if ($user->id == 1) {
                $flag = 1; continue;
            }
            $user->delete();
        }
        $message = ['success', 'Selected users have been deleted'];
        if ($flag == 1) $message = ['failed', 'Can\'t delete protected record'];
        return redirect('/admin/users')->with($message[0],$message[1]);
    }
}
