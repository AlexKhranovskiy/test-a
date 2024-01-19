<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Position;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(45)->create();
        $positions = Position::factory(5)->create();


        $users->each(function (User $user) use ($positions) {
            //$positions->random()->update(['user_id' => $user->id]);
//            $positions->save();
            $user->position()->associate($positions->random());
            $user->save();
//            $positions->each(function (Position $position) use ($user) {
//
//            });
        });
    }
}
