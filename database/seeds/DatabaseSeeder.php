<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table("users")->insert([
            "name" => "admin",
            "email" => "panchasilmedia@gmail.com",
            "password" => Hash::make("@@panchasil@@"),
        ]);
         DB::table("users")->insert([
        "name"=>"ashish",
        "email"=>"ashish336b@gmail.com",
        "password"=> Hash::make("11111111")
        ]);
         DB::table("categories")->insert([
    "name"=>"Testing",
    "status"=>"pending",
    "image"=>"a.jpg",
    "slug"=>"testing"
    ]);
    $faker = \Faker\Factory::create('App/News');
    for($i=0;$i<100;$i++){
    DB::table("news")->insert([
    "title"=>$faker->firstName,
    "author"=>$faker->lastName,
    "image"=>"a.jpg",
    "taja_khabar"=>null,
    "headline"=>null,
    "related"=>null,
    "description"=>"asdf",
    "category_id"=>1,
    "status"=>"pending",
    "slug"=>"news$i",
    ]);
    }
    }
}
