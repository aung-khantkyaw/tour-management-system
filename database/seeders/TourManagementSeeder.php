<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TourManagementSeeder extends Seeder
{
    public function run(): void
    {
        // Users
        DB::table('users')->insertOrIgnore([
            ['name' => 'Myat Thu', 'email' => 'myat123@gmail.com', 'password' => Hash::make('myat123'), 'role' => 'user'],
            ['name' => 'Phoo', 'email' => 'phoo123@gmail.com', 'password' => Hash::make('phoo123'), 'role' => 'user'],
            ['name' => 'Hnin', 'email' => 'hnin123@gmail.com', 'password' => Hash::make('hnin123'), 'role' => 'admin']
        ]);

        // Destinations
        DB::table('destinations')->insert([
            ['destination_name' => 'kyaiktiyo', 'destination_profile' => '', 'city' => 'thanton', 'description' => 'Mount Kyaiktiyo, famous for the huge golden rock p'],
            ['destination_name' => 'shwedagon', 'destination_profile' => '', 'city' => 'yangon', 'description' => 'The Shwedagon is the most sacred Buddhist pagoda i'],
        ]);

        // Guides
        DB::table('guides')->insert([
            ['gname' => 'Ei Mon Zaw', 'email' => 'emz123@gmail.com', 'phone' => '09769756677', 'language' => 'English'],
            ['gname' => 'Nyein Yi Linn', 'email' => 'nyl123@gmail.com', 'phone' => '09667542516', 'language' => 'Chinese'],
        ]);

        // Rooms
        DB::table('rooms')->insert([
            ['room_type' => 'single'],
            ['room_type' => 'family'],
        ]);

        // Hotels
        DB::table('hotels')->insert([
            ['destination_id' => 1, 'name' => 'Sweet Home', 'contact_no' => '09650077400', 'rating' => 5],
            ['destination_id' => 2, 'name' => 'Five Star', 'contact_no' => '09418155885', 'rating' => 5],
        ]);

        // Tourist Packages
        DB::table('tourist_packages')->insert([
            ['package_name' => 'Shwedagon Tour', 'guide_id' => 1, 'destination_id' => 2, 'duration_days' => '3 Days 2 Nights Trip', 'no_of_people' => 5, 'vehicle_type' => 'Hnin Cherry Car', 'singlepackage_fee' => 150000, 'fullpackage_fee' => 300000],
            ['package_name' => 'Kyaiktiyo Tour', 'guide_id' => 2, 'destination_id' => 1, 'duration_days' => '3 Days 2 Nights Trip', 'no_of_people' => 20, 'vehicle_type' => 'Say Ta Man Car', 'singlepackage_fee' => 150000, 'fullpackage_fee' => 1000000],
        ]);

        // Accommodations
        DB::table('accommodations')->insert([
            ['hotel_id' => 1, 'room_id' => 1, 'price' => 20000],
            ['hotel_id' => 2, 'room_id' => 2, 'price' => 80000],
        ]);

        // Schedules
        DB::table('schedules')->insert([
            ['package_id' => 1, 'from_date' => '2025-10-05', 'to_date' => '2025-10-07', 'departure_time' => '10 AM', 'arrival_time' => '12AM'],
            ['package_id' => 2, 'from_date' => '2025-10-06', 'to_date' => '2025-10-08', 'departure_time' => '8 AM', 'arrival_time' => '1 PM'],
        ]);

        // Bookings
        DB::table('bookings')->insert([
            ['user_id' => 1, 'schedule_id' => 1, 'booking_date' => '2025-10-03', 'payment_status' => 'Kpay', 'special_request' => 'Pls!!!', 'address' => 'Singapore', 'phone' => '09661437317', 'nationality' => 'Singaporean', 'package_status' => 'One Person Package'],
            ['user_id' => 2, 'schedule_id' => 2, 'booking_date' => '2025-10-01', 'payment_status' => 'Wave Pay', 'special_request' => 'Pls!!!!', 'address' => 'Thailand', 'phone' => '09763287905', 'nationality' => 'Thai', 'package_status' => 'Group Package'],
        ]);

        // Room Choices
        DB::table('room_choices')->insert([
            ['booking_id' => 1, 'accom_id' => 2],
            ['booking_id' => 1, 'accom_id' => 1],
            ['booking_id' => 2, 'accom_id' => 1],
        ]);
    }
}