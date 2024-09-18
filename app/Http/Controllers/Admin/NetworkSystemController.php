<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\NetworkSystem;

class NetworkSystemController extends Controller
{
    public function cooperate() {
        $networks = NetworkSystem::all(); // Truy xuất tất cả dữ liệu
        return view('Admin.cooperate', compact('networks')); // Truyền dữ liệu vào view
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'khuvuc' => 'required|string|max:255',
        ]);

        NetworkSystem::create($request->all()); // Lưu dữ liệu vào database
        return redirect()->route('admin.cooperate')->with('success', 'Mạng hệ thống đã được thêm thành công.');
    }

    public function edit($id_doitac) {
        $network = NetworkSystem::findOrFail($id_doitac); // Tìm mạng hệ thống theo ID
        return view('Admin.cooperate', compact('network')); // Hiển thị form chỉnh sửa
    }

    public function update(Request $request, $id_doitac) {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'khuvuc' => 'required|string|max:255',
        ]);

        $network = NetworkSystem::findOrFail($id_doitac);
        $network->update($request->all()); // Cập nhật dữ liệu
        return redirect()->route('admin.cooperate')->with('success', 'Mạng hệ thống đã được cập nhật thành công.');
    }

    public function destroy($id_doitac) {
        $network = NetworkSystem::findOrFail($id_doitac); // Sử dụng id_doitac
        $network->delete(); // Xóa mạng hệ thống
        return redirect()->route('admin.cooperate')->with('success', 'Mạng hệ thống đã được xóa thành công.');
    }
}
