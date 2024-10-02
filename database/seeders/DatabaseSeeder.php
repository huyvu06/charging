<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\car;
use App\Models\ChargingPort;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        $ChargingPort = [
            ['cong_sac' => 'CCS'],
            ['cong_sac' => 'Type 2'],
            // Thêm nhiều loại cổng sạc khác nếu cần
        ];

        // Insert data into the charging_ports table
        foreach ($ChargingPort as $port) {
            ChargingPort::create($port);
        }
        // Fetch all charging ports after they have been created
        $ChargingPort = ChargingPort::all();

        // Sample data for cars, associating them with charging ports
        $car = [
            // Xe sử dụng cổng sạc CCS
            ['name' => 'Tesla Model 3', 'charging_port_id' => $ChargingPort->where('cong_sac', 'CCS')->first()->id_charging_port],
            ['name' => 'Audi e-tron', 'charging_port_id' => $ChargingPort->where('cong_sac', 'CCS')->first()->id_charging_port],
            ['name' => 'Hyundai Kona Electric', 'charging_port_id' => $ChargingPort->where('cong_sac', 'CCS')->first()->id_charging_port],
            ['name' => 'Volkswagen ID.4', 'charging_port_id' => $ChargingPort->where('cong_sac', 'CCS')->first()->id_charging_port],
            ['name' => 'Ford Mustang Mach-E', 'charging_port_id' => $ChargingPort->where('cong_sac', 'CCS')->first()->id_charging_port],
        
            // Xe sử dụng cổng sạc Type 2
            ['name' => 'BMW i3', 'charging_port_id' => $ChargingPort->where('cong_sac', 'Type 2')->first()->id_charging_port],
            ['name' => 'Nissan Leaf', 'charging_port_id' => $ChargingPort->where('cong_sac', 'Type 2')->first()->id_charging_port],
            ['name' => 'Kia e-Niro', 'charging_port_id' => $ChargingPort->where('cong_sac', 'Type 2')->first()->id_charging_port],
            ['name' => 'Porsche Taycan', 'charging_port_id' => $ChargingPort->where('cong_sac', 'Type 2')->first()->id_charging_port],
            ['name' => 'Mercedes-Benz EQC', 'charging_port_id' => $ChargingPort->where('cong_sac', 'Type 2')->first()->id_charging_port],
        ];

        // Insert data into the cars table
        foreach ($car as $car) {
            Car::create($car);
        }
        
    }
}
