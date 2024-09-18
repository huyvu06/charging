<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Hiển thị danh sách người dùng
    public function account()
    {
        $users = User::all();
        return view('Admin.account', compact('users'));
    }

    // Thêm người dùng mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.account')->with('success', 'Thêm người dùng thành công.');
    }

    // Hiển Thị nội dữ liệu người dùng 
    public function edit($id)
    {
        $user = User::findOrFail($id); // Sử dụng id
        return view('Admin.edit', compact('user'));
    }

    // Sửa dữ liệu người dùng
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id . ',id', // Sử dụng id
            'role' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id); // Sử dụng id
        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.account')->with('success', 'Sửa người dùng thành công.');
    }

    // Xóa người dùng
    public function destroy($id)
    {
        $user = User::findOrFail($id); // Sử dụng id
        $user->delete();

        return redirect()->route('admin.account')->with('success', 'Xóa người dùng thành công.');
    }
}
