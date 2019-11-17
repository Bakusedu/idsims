<?php

use Illuminate\Database\Seeder;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customer')->insert([
            'name' => Str::random(10),
            'email' => Str::random(10).'.gmail.com',
            'age' => 23,
            'password' => Str::random(10),
            'phone' => '08122632296',
            'picture' => Str::random(4).'.jpg',
            'customer_id' => Str::random(5).'OTC',
        ]);
    }
}
