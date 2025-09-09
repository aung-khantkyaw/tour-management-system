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
            ['destination_name' => 'Kyaiktiyo Pagoda', 'destination_profile' => 'destinations/qp90XvUgAXdoUvnM1xmEfJXWKoPDkqjHcWdOHiUr.jpg', 'city' => 'Thanton', 'description' => 'Kyaiktiyo Pagoda (Burmese: ကျိုက်ထီးရိုးဘုရား pronounced [tɕaɪʔtʰíjó pʰəjá] or ဆံတော်ရှင်ကျိုက်ထီးရိုးစေတီတော်မြတ်; Mon: ကျာ်သိယဵု [tɕaiʔ sɔeʔ jɜ̀]listenⓘ; also known as Golden Rock[1]) is a well-known Buddhist pilgrimage site in Mon State, Myanmar. It is a small pagoda (7.3 m (24 ft)) built on the top of a granite boulder covered with gold leaves pasted on by its male worshippers.'],
            ['destination_name' => 'Shwedagon Pagoda', 'destination_profile' => 'destinations/kN6tV7uvXhLONygzEz1he1Qmtdkpxa9b0NgvPRTm.jpg', 'city' => 'Yangon', 'description' => 'The Shwedagon Pagoda (Burmese: ရွှေတိဂုံဘုရား; MLCTS: shwe ti. gon bhu. ra:, IPA: [ʃwèdəɡòʊɰ̃ pʰəjá]; Mon: ကျာ်ဒဂုၚ်), officially named Shwedagon Zedi Daw (Burmese: ရွှေတိဂုံစေတီတော်, [ʃwèdəɡòʊɰ̃ zèdìdɔ̀], lit. \'Golden Dagon Pagoda\'), and also known as the Great Dagon Pagoda and the Golden Pagoda, is a gilded stupa located in Yangon, Myanmar.\r\n\r\nThe Shwedagon is the most sacred Buddhist pagoda in Myanmar, as it is believed to contain relics of the four previous Buddhas of the present kalpa. These relics include the staff of Kakusandha, the water filter of Koṇāgamana, a piece of the robe of Kassapa, and eight strands of hair from the head of Gautama.[2]'],
        ]);

        // Guides
        DB::table('guides')->insert([
            ['gname' => 'Ei Mon Zaw', 'email' => 'emz123@gmail.com', 'phone' => '09769756677', 'language' => 'English'],
            ['gname' => 'Nyein Yi Linn', 'email' => 'nyl123@gmail.com', 'phone' => '09667542516', 'language' => 'Chinese'],
        ]);

        // Rooms
        DB::table('rooms')->insert([
            ['room_type' => 'SINGLE'],
            ['room_type' => 'FAMILY'],
            ['room_type' => 'DOUBLE'],
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
            ['package_id' => 1, 'from_date' => '2025-10-05', 'to_date' => '2025-10-07', 'departure_time' => '10 AM', 'arrival_time' => '12AM', 'available_places' => 3], // 5 capacity - 2 single bookings = 3 available
            ['package_id' => 2, 'from_date' => '2025-10-06', 'to_date' => '2025-10-08', 'departure_time' => '8 AM', 'arrival_time' => '1 PM', 'available_places' => 0], // full package booked = 0 available
        ]);

        // Bookings
        DB::table('bookings')->insert([
            ['user_id' => 1, 'schedule_id' => 1, 'booking_date' => '2025-10-03', 'payment_method' => 'KBZPay', 'special_request' => 'Pls!!!', 'address' => 'Singapore', 'phone' => '09661437317', 'nationality' => 'Singaporean', 'booking_status' => 'pending', 'total_amount' => 100000.00, 'payment_transaction_id' => '12345678901234567890', 'package_type' => 'single'],
            ['user_id' => 2, 'schedule_id' => 2, 'booking_date' => '2025-10-01', 'payment_method' => 'AyarPay', 'special_request' => 'Pls!!!!', 'address' => 'Thailand', 'phone' => '09763287905', 'nationality' => 'Thai', 'booking_status' => 'confirmed', 'total_amount' => 1000000.00, 'payment_transaction_id' => '09876543210987654321', 'package_type' => 'full'],
            ['user_id' => 1, 'schedule_id' => 1, 'booking_date' => '2025-09-06', 'payment_method' => 'KBZPay', 'special_request' => 'plz', 'address' => 'No.806, Khaing Shwe War Street', 'phone' => '09421836385', 'nationality' => 'Myanmar', 'booking_status' => 'confirmed', 'total_amount' => 230000.00, 'payment_transaction_id' => '01234567890123456789', 'package_type' => 'single'],
        ]);

        // Room Choices
        DB::table('room_choices')->insert([
            ['booking_id' => 1, 'accom_id' => 2],
            ['booking_id' => 1, 'accom_id' => 1],
            ['booking_id' => 2, 'accom_id' => 1],
            ['booking_id' => 3, 'accom_id' => 2],
        ]);
    }
}