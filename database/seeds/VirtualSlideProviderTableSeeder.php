<?php

use Illuminate\Database\Seeder;
use App\VirtualSlideProvider;
class VirtualSlideProviderTableSeeder extends Seeder
{
    public function run()
    {
        VirtualSlideProvider::create([
            'name' => 'Rosai Collection',
            'url'  => 'http://www.rosaicollection.net/'
        ]);

        VirtualSlideProvider::create([
            'name' => 'University of Leeds',
            'url'  => 'http://www.virtualpathology.leeds.ac.uk/slidelibrary/index.php'
        ]);
    }
} 