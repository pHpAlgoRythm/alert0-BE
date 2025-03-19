<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SystemPhoto;
use Illuminate\Support\Carbon;

class SystemPhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $systemPhotos = [
            [
                'photo_name' => 'logo',
                'photo' => 'http://127.0.0.1:8000/storage/system_photo/zmiZrVKQ9uk96ehkN4ZZIzre6SAOjucSxIPKHcD5.png'
            ],
            [
                'photo_name' => 'ambulance',
                'photo' => 'http://127.0.0.1:8000/storage/system_photo/FdcuSwj68NgWgpGevdnBrN7nvGpdggBrY5Bs8fnH.jpg'
            ],
            [
                'photo_name' => 'firetruck',
                'photo' => 'http://127.0.0.1:8000/storage/system_photo/EMLn4dm983wTusiSEyHLbJtHxFhCdRE3pBYH1xnp.jpg'
            ],
            [
                'photo_name' => 'default-profile',
                'photo' => 'http://127.0.0.1:8000/storage/system_photo/YxtIjQP9XqiijqgjbrOC6BeLuhkpxfAAJNnRlNEJ.jpg'
            ],
        ];



        foreach ($systemPhotos as $photo) {
          $record =  SystemPhoto::create([
                'photo_name' => $photo['photo_name'],
                'photo' => $photo['photo'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);

            dump($record);
        }
    }
}
