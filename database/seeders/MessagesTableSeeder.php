<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('messages')->insert([
            [
                'sender_id'   => 1,
                'receiver_id' => 2,
                'message'     => 'Hello! How are you?',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'sender_id'   => 2,
                'receiver_id' => 1,
                'message'     => 'I am good, thanks! What about you?',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'sender_id'   => 1,
                'receiver_id' => 2,
                'message'     => 'I am doing great! Working on a project.',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
            [
                'sender_id'   => 2,
                'receiver_id' => 1,
                'message'     => 'That sounds interesting! Need any help?',
                'created_at'  => Carbon::now(),
                'updated_at'  => Carbon::now(),
            ],
        ]);
    }
}
