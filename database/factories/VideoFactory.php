<?php

use Faker\Factory;

use App\Video;

$factory->define(Video::class, function () {
    $faker = Factory::create('fr_FR');

    $video_files = scandir(public_path('/uploads/videos/'));

    return [
        'name' => $faker->sentence(4, true),
        'video_file' => $video_files[array_rand($video_files)],
        'description' => $faker->paragraph(100),
        'preview' => $faker->image('public/uploads/images',400,300, null, false),
        'is_visible' => $faker->randomElement([true, false])
    ];
});
