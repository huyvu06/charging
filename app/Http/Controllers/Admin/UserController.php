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
        $users = User::with('userProfile')->get();
        return view('Admin.account', compact('users'));
    }

    public function addUser(Request $request)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users,email', // Ensure email is unique
            'role' => 'required|string|max:255',
            'password' => 'required|string|min:6', // Validate password length
        ]);

        // Create a new user with the validated data
        User::create([
            'email' => $validatedData['email'],
            'role' => $validatedData['role'],
            'password' => bcrypt($validatedData['password']), // Hash the password
        ]);

        // Redirect back to the account listing with a success message
        return redirect()->route('admin.account')->with('success', 'Thêm người dùng thành công.');
    }


    // Hiển Thị nội dữ liệu người dùng 
    public function editUser($id)
    {
        $user = User::findOrFail($id); // Sử dụng id
        return view('Admin.edit', compact('user'));
    }

    // Sửa dữ liệu người dùng
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $id . ',id', // Sử dụng id
            'role' => 'required|string|max:255',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id); // Sử dụng id
        $user->email = $request->email;
        $user->role = $request->role;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->save();

        return redirect()->route('admin.account')->with('success', 'Sửa người dùng thành công.');
    }

    // Xóa người dùng
    public function destroyUser($id)
    {
        $user = User::findOrFail($id); // Sử dụng id
        $user->delete();

        return redirect()->route('admin.account')->with('success', 'Xóa người dùng thành công.');
    }
    
    // Reset mật khẩu người dùng
    public function resetPassword(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'password' => 'required|string|min:6', // Đảm bảo mật khẩu có độ dài tối thiểu là 6
        ]);

        $user = User::findOrFail($id); // Tìm người dùng theo id
        $user->password = bcrypt($request->password); // Mã hóa mật khẩu mới
        $user->save(); // Lưu thay đổi

        return redirect()->route('admin.account')->with('success', 'Đặt lại mật khẩu thành công.');
    }

}
?>