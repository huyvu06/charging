<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ChargingPort;
use App\Models\Car;

class ChargingPortController extends Controller
{
    public function chargingPorts()
    {
        $chargingPort = ChargingPort::with('tramSacs', 'cars')->get();
        $cars = Car::all(); // Lấy tất cả xe

        return view('Admin.chargingPort', compact('chargingPort', 'cars'));
    }

    public function addPort(Request $request)
    {
        $request->validate([
            'cong_sac' => 'required|string|max:255',
            'car_name' => 'required|string|max:255',
        ]);

        $chargingPort = new ChargingPort();
        $chargingPort->cong_sac = $request->input('cong_sac');
        $chargingPort->save(); // Save charging port first to get its ID

        // Lưu tên xe
        $carNames = explode(',', $request->input('car_name'));
        foreach ($carNames as $carName) {
            $car = new Car();
            $car->name = trim($carName);
            $car->charging_port_id = $chargingPort->id; // Set the charging_port_id
            $chargingPort->cars()->save($car);
        }

        return redirect()->back()->with('success', 'Cổng sạc đã được thêm thành công.');
    }

    public function updatePort(Request $request, $id)
    {
        $request->validate([
            'cong_sac' => 'required|string|max:255',
            'car_name' => 'required|string|max:255',
        ]);

        $chargingPort = ChargingPort::findOrFail($id);
        $chargingPort->cong_sac = $request->input('cong_sac');

        // Cập nhật tên xe
        $carNames = explode(',', $request->input('car_name'));
        $chargingPort->cars()->delete(); // Xóa các xe cũ (nếu có)

        foreach ($carNames as $carName) {
            $car = new Car();
            $car->name = trim($carName);
            $car->charging_port_id = $chargingPort->id; // Set the charging_port_id
            $chargingPort->cars()->save($car);
        }

        $chargingPort->save();
        return redirect()->back()->with('success', 'Cổng sạc đã được cập nhật thành công.');
    }

    // Xóa cổng sạc
    public function destroyPort($id)
    {
        $chargingPort = ChargingPort::findOrFail($id);
        $chargingPort->delete();

        return redirect()->route('admin.chargingPort')->with('success', 'Cổng sạc đã được xóa thành công!');
    }
}
