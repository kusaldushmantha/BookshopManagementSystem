<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $time = new DateTime();

        DB::table('users')->insert([
            'firstname'=>'kusal',
            'lastname'=>'kankanamge',
            'username'=>'kusal',
            'password'=>bcrypt('kusal'),
            'contactno'=>'0778488709',
            'accesslevel'=>'admin',
            'updated_at'=>$time->getTimestamp(),
            'created_at'=>$time->getTimestamp()
        ]);
    }
}
