<?php
namespace App\Http\Controllers;

use App\Models\news;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function news()
    {
        $news = News::all();
        return view('Admin.news', compact('news'));
    }

    public function addNews(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'images' => 'array|max:5', // Thêm xác thực cho mảng ảnh, tối đa 5 ảnh
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Allow multiple images
        'noidung' => 'required|string',
    ]);

    $imagePaths = [];

    foreach ($request->file('images') as $image) {
        $path = $image->store('images/news', 'public');
        $imagePaths[] = $path;  // Store image path
    }

    // Create a new news post
    News::create([
        'title' => $request->title,
        'image' => json_encode($imagePaths), // Store paths as JSON
        'noidung' => $request->noidung,
        'date_up' => now(), // Set the creation date
        'view' => 0,
        'binhluan' => 0,
    ]);

    return redirect()->route('admin.news')->with('success', 'Bài viết đã được thêm thành công!');
}

    public function updateNews(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'images' => 'array|max:5', // Thêm xác thực cho mảng ảnh, tối đa 5 ảnh
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Tùy chọn
        'noidung' => 'required|string',
    ]);

    $news = News::findOrFail($id);

    // Cập nhật tiêu đề và nội dung
    $news->title = $request->title;
    $news->noidung = $request->noidung;

    // Kiểm tra xem có ảnh mới được gửi lên không
    if ($request->hasFile('images')) {
        // Xóa toàn bộ ảnh cũ
        $oldImagePaths = json_decode($news->image, true) ?? []; // Khởi tạo với mảng rỗng nếu null
        foreach ($oldImagePaths as $oldImage) {
            // Kiểm tra và xóa ảnh cũ
            if (file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }

        // Xử lý upload ảnh mới
        $imagePaths = []; // Mảng để lưu đường dẫn ảnh mới
        foreach ($request->file('images') as $image) {
            $path = $image->store('images/news', 'public');
            $imagePaths[] = $path; // Lưu đường dẫn ảnh mới
        }

        $news->image = json_encode($imagePaths); // Cập nhật đường dẫn ảnh
    }

    $news->save(); // Lưu lại thay đổi

    return redirect()->route('admin.news')->with('success', 'Bài viết đã được cập nhật thành công!');
}


    public function deleteNews($id)
    {
        $news = News::findOrFail($id); // Sẽ ném ra 404 nếu không tìm thấy
        $news->delete(); // Xóa mục tin tức

        return redirect()->route('admin.news')->with('success', 'Bài viết đã được xóa thành công!');
    }
}
?>