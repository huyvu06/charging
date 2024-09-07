<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tramsac;
use Illuminate\Support\Facades\Auth;

class TramSacController extends Controller
{
    public function store(Request $request)
    {
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Bạn cần phải đăng nhập để thực hiện thao tác này.');
        }

        // Xác thực các trường yêu cầu (nếu cần)
        $request->validate([
            'name' => 'required|string|max:255',
            'name_tramsac' => 'required|string|max:255',
            'address' => 'required|string',
            // Các trường khác không bắt buộc đã có nullable() trong migration
        ]);

        try {
            // Lấy user_id từ người dùng hiện tại
            $user_id = Auth::id();

            // Tạo mới trạm sạc
            $tramSac = new TramSac();
            $tramSac->name = $request->input('name');
            $tramSac->phone = $request->input('phone');
            $tramSac->name_tramsac = $request->input('name_tramsac');
            $tramSac->content = $request->input('content');
            $tramSac->map = $request->input('map'); // Kinh độ và vĩ độ
            $tramSac->address = $request->input('address');
            $tramSac->user_id = $user_id; // Gán user_id hiện tại
            $tramSac->id_doitac = null; // Cập nhật nếu có id_doitac
            $tramSac->save();

            // Chuyển hướng với thông báo thành công
            return redirect()->route('tramsac')->with('success', 'Đã gửi thông tin đăng ký trạm sạc thành công.');

        } catch (\Exception $e) {
            // Xử lý lỗi nếu xảy ra
            return back()->with('error', 'Có lỗi xảy ra khi đăng ký trạm sạc: ' . $e->getMessage());
        }
    }
}
