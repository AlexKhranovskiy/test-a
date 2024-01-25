<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\AuthenticatorUser;
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
        AuthenticatorUser::factory(1)->create();
        $users = User::factory(2)->create();
        $positions = Position::factory(5)->create();


        $users->each(function (User $user) use ($positions) {
            $user->position()->associate($positions->random());
            $user->save();
        });
    }
}
