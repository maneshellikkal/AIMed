<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * @return void
     */
    public function run ()
    {
        $users = factory('App\User', 10)->create();

        for ($i = 1; $i <= 7; $i++) {
            $dataset = create('App\Dataset', ['user_id' => User::inRandomOrder()->first()->id]);
            for ($j = 1; $j <= 30; $j++) {
                create('App\Code', ['dataset_id' => $dataset->id, 'user_id' => User::inRandomOrder()->first()->id]);
            }
        }
    }
}
