<?php

use App\Support;
use Illuminate\Database\Seeder;

class SupportTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Support::create([
            'supp'  =>0.02
        ]);
    }
}
