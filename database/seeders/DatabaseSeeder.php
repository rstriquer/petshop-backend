<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();

            User::factory(10)->create();

            DB::commit();
        } catch(\Exception $err) {
            DB::rollBack();
            throw $err;
        }
    }
}
