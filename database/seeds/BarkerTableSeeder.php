<?php

use Illuminate\Database\Seeder;

class BarkerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        factory(App\Braker::class)->create();
    }
}
