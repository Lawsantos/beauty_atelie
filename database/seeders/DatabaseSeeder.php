<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Procedure;
use App\Models\Reserve;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('adminadmin')

        ]);

        if(app()->environment('local')) {
            Client::factory(100)->create();
            foreach (['Depilação', 'Massagem', 'Cilios', 'Manicure / pedicure', 'Maquiagem'] as $procedure) {
                Procedure::factory()->create(['name' => $procedure]);
            }
            Reserve::factory(50)->create();
        }

    }
}
