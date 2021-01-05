<?php

use Illuminate\Database\Seeder;

class UserSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::query()->create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password'=>\Illuminate\Support\Facades\Hash::make('secret')
        ]);
    }
}
