<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserProfile;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Mail\VerificationMail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Facades\Session;
class UserController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }
    public function sign()
    {
        return view('auth.sign');
    }


    public function postSign(Request $req)
    {

        $validatedData = $req->validate([
            'role' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'name' => 'required|string|max:255',
            'phone' => 'regex:/^0[0-9]{9,10}$/|numeric',
            'address' => 'nullable|string|max:255',
            'sex' => 'nullable|in:male,female',
        ]);


        if (User::where('email', $req->email)->exists()) {
            return redirect()->back()
                ->withErrors(['email' => 'Email này đã được sử dụng để đăng ký tài khoản.'])
                ->withInput();
        }

        DB::beginTransaction();

        try {

            $user = User::create([
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);


            UserProfile::create([
                'name' => $validatedData['name'],
                'phone' => $validatedData['phone'] ?? null,
                'address' => $validatedData['address'] ?? null,
                'sex' => $validatedData['sex'] ?? null,
                'user_id' => $user->id,
            ]);

            // Tạo mã xác thực 6 số
            $token = rand(100000, 999999);
            \Log::info('Verification token:', ['token' => $token]);
            $user->update(['verification_token' => $token]);

            Mail::to($user->email)->send(new VerificationMail($token));
            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage(), $th->getTrace());
            return redirect()->back()
                ->withErrors(['error' => 'Đã xảy ra lỗi khi tạo tài khoản và hồ sơ.'])
                ->withInput();
        }

        return redirect()->route('verify')->with('success', 'Đăng ký thành công. Vui lòng kiểm tra email để xác thực.');
    }



    public function showVerifyForm()
    {
        return view('auth.verify');
    }

    public function verifyToken(Request $request)
{
    $request->validate([
        'token' => 'required|string|digits:6',
    ]);


    $user = User::where('verification_token', $request->input('token'))->first();

    \Log::info('User:', ['user' => $user]);
    \Log::info('Token:', ['input_token' => $request->input('token')]);

    if (!$user) {
        return redirect()->route('verify')->with('error', 'Mã xác thực không đúng hoặc đã hết hạn. Vui lòng thử lại.');
    }

    $user->update(['verification_token' => null]);

    return redirect()->route('login')->with('success', 'Xác thực thành công. Bạn có thể đăng nhập.');
}

    




    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        $request->session()->regenerate();

        return redirect()->route('login');
    }

    public function postLogin(Request $req)
{
    $credentials = $req->only('email', 'password');
    $remember = $req->has('remember');


    if (Auth::attempt($credentials, $remember)) {
        $user = Auth::user();
        if ($user->verification_token !== null) {
            Auth::logout(); 
            return redirect()->back()->with('error', 'Bạn cần xác thực tài khoản trước khi đăng nhập.');
        }

        session(['user_name' => $user->userProfile->name]);
        \Log::info('User logged in:', ['user_id' => $user->id]);
        return redirect()->route('home');
    }

    return redirect()->back()->with('error', 'Thông tin đăng nhập không đúng.');
}


    public function showProfile()
    {
        $user = Auth::user()->load('userProfile');

        return view('auth.profile', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
 
        $user->userProfile->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'sex' => $request->input('sex'),
        ]);
 
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->getRealPath();
            $imageData = file_get_contents($imagePath);
            $base64Image = base64_encode($imageData);
 
            $user->userProfile->update([
                'image' => $base64Image,
            ]);
        }
 
        return redirect()->route('show.profile')->with('success', 'Thông tin cá nhân đã được cập nhật!');
    }
}
