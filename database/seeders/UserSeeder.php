<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Request();
        $user->name = "Leticia Blanco Coca";
        $user->username = "lety123";
        $user->email="lalety123@gmail.com";
        //$user->password= Hash::make('lety123');
       // $user->save();

    }
}

