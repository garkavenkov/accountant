<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        
        factory('App\Models\User')->create([
            'name'                  =>  'Administrator',
            'username'              =>  'admin',
            'email'                 =>  'admin@example.net',
            'email_verified_at'     =>  now(),
            'password'              =>  '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'api_token'             =>  Str::random(80),
            'remember_token'        =>  Str::random(10),    
        ]);
    }
}
