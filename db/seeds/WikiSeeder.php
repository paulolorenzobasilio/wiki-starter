<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;
use Cocur\Slugify\Slugify;
use Ramsey\Uuid\Uuid;

class WikiSeeder extends AbstractSeed
{
    public function run(): void
    {
        $faker = Faker\Factory::create();
        $slugify = new Slugify();

        for($i=0; $i<10; $i++){
            $title = $faker->unique()->company();
            $url = sprintf("$title-%s", Uuid::uuid4()->toString());

            $data[] =  [
                'title' => $title,
                'description' => $faker->unique()->realText,
                'url' => $slugify->slugify($url)
            ];
        }

        $wiki = $this->table('wiki');
        $wiki->insert($data)
            ->saveData();
    }
}
