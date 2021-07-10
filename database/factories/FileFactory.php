<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

class FileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = File::class;

    /**
     * Define thex model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id_user' => 1,
            'size' => random_int(1024, 8388608),
            'path' => 'test.txt',
        ];
    }
}
