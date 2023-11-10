<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Cocur\Slugify\Slugify;
class WikiSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $slugify = new Slugify();

        for($i=0; $i<10; $i++){
            $title = $faker->unique()->company();
            $data[] =  [
                'title' => $title,
                'description' => $faker->unique()->realText,
                'url' => "/{$slugify->slugify($title)}"
            ];
        }

        $wiki = $this->table('wiki');
        $wiki->insert($data)
            ->saveData();
    }
}
