<?php

namespace Database\Seeders;

use App\Models\CommentModel;
use Illuminate\Database\Seeder;

class CommentSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CommentModel::factory(1000)->create();
    }
}
