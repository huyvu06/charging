<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TramSac;
use Storage;

class ChargingStationController extends Controller
{
    // Hiển thị danh sách các trạm sạc
    public function chargingStation()
    {
        $tramSacs = TramSac::all(); // Lấy tất cả các trạm sạc
        return view('Admin.chargingStation', compact('tramSacs'));
    }

    // Thêm trạm sạc mới
    public function addChargingStation(Request $request)
    {
        $validated = $request->validate([
            'name_tramsac' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_lat' => 'required|numeric',
            'map_lon' => 'required|numeric',
        ]);

        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/tramsac', 'public');
            $validated['image'] = $imagePath; // Lưu đường dẫn hình ảnh vào mảng validated
        }

        TramSac::create($validated); // Tạo mới trạm sạc

        return redirect()->back()->with('success', 'Thêm trạm sạc thành công!'); // Thông báo thành công
    }

    // Cập nhật thông tin trạm sạc
    public function updateChargingStation(Request $request, $id)
    {
        $tramSac = TramSac::findOrFail($id); // Tìm trạm sạc theo ID

        $validated = $request->validate([
            'name_tramsac' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'address' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'map_lat' => 'required|numeric',
            'map_lon' => 'required|numeric',
        ]);

        // Xử lý upload hình ảnh
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu có
            if ($tramSac->image) {
                Storage::delete('public/' . $tramSac->image);
            }
            $imagePath = $request->file('image')->store('images/tramsac', 'public');
            $validated['image'] = $imagePath; // Cập nhật đường dẫn hình ảnh
        }

        $tramSac->update($validated); // Cập nhật trạm sạc

        return redirect()->back()->with('success', 'Cập nhật trạm sạc thành công!'); // Thông báo thành công
    }

    // Xóa trạm sạc
    public function destroyChargingStation($id)
    {
        $tramSac = TramSac::findOrFail($id); // Tìm trạm sạc theo ID
        
        // Xóa hình ảnh nếu có
        if ($tramSac->image) {
            Storage::delete('public/' . $tramSac->image);
        }

        $tramSac->delete(); // Xóa trạm sạc
        
        return redirect()->back()->with('success', 'Xóa trạm sạc thành công!'); // Thông báo thành công
    }
}
