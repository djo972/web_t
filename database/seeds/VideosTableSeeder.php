<?php

use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $videos = array(
            "http://install.anypli.com/webtv/videos/casino.mp4",
            "http://install.anypli.com/webtv/videos/evenement_6.mp4",
            "http://install.anypli.com/webtv/videos/casino_2.mp4",
            "http://install.anypli.com/webtv/videos/evenement.mp4",
            "http://install.anypli.com/webtv/videos/instit.mp4",
            "http://install.anypli.com/webtv/videos/teaser.mp4",
        );


        //Download test videos
        foreach ($videos as $video) {
            $video_name = basename(parse_url($video, PHP_URL_PATH));
            $video_path = public_path('/uploads/videos/')  . $video_name;
            
            if (!file_exists($video_path)) {
                echo "Downloading video $video_name \n";
                file_put_contents($video_path, file_get_contents("$video"));
            }else{
                echo "File $video_name already exist - skip download \n";
            }
        }

        factory(App\Video::class, 10)->create()->each(function($vid) {
            $vid->themes()->sync(
                App\Theme::all()->random(1)
            );
        });
    }
}
