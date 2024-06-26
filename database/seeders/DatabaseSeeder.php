<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory()->create([
        //     'username' => 'wahyupct',
        //     'role_id' => 1,
        //     'name' => 'Wahyu Tri Cahyono',
        //     'email' => 'wahyutricahyono777@gmail.com',
        //     'password' => Hash::make('password'),
        // ]);

        // // \App\Models\User::factory(10)->create();

        \App\Models\Role::create([
            'name' => 'admin'
        ]);

        \App\Models\Role::create([
            'name' => 'helpdesk'
        ]);

        \App\Models\Role::create([
            'name' => 'technician'
        ]);

        \App\Models\Role::create([
            'name' => 'user'
        ]);

        \App\Models\Status::create([
            'name' => 'registrasi',
            'description' => 'status ticket waiting'
        ]);

        \App\Models\Status::create([
            'name' => 'vertifikasi',
            'description' => 'status ticket masuk ke antrian'
        ]);

        \App\Models\Status::create([
            'name' => 'proses',
            'description' => 'status ticket sudah diset ke proces'
        ]);

        \App\Models\Status::create([
            'name' => 'selesai',
            'description' => 'status ticket sudah selesai'
        ]);

        \App\Models\Status::create([
            'name' => 'tolak',
            'description' => 'status ticket sudah ditolak'
        ]);

        // \App\Models\Device::factory(10)->create();

        // \App\Models\Ticket::factory(10)->create();

        // \App\Models\Proces::factory(10)->create();
    }
}
