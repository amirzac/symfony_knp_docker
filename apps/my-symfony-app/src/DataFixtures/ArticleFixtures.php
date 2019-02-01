<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Tag;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Comment;

class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    private static $articleImages = [
        'asteroid.jpeg',
        'mercury.jpeg',
        'lightspeed.png',
    ];
    private static $articleAuthors = [
        'Mike Ferengi',
        'Amy Oort',
    ];

    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Article::class, 10, function(Article $article, $count) use ($manager) {
            $article->setTitle($this->faker->text(50))
                ->setContent($this->faker->paragraph(12));

            // publish most articles
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-100 days', '-1 days'));
            }
            $article->setAuthor($this->faker->randomElement(self::$articleAuthors))
                ->setImageFilename($this->faker->randomElement(self::$articleImages));

            $tags = $this->getRandomReferences(Tag::class, $this->faker->numberBetween(0, 5));
            foreach ($tags as $tag) {
                $article->addTag($tag);
            }
        });

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            TagFixture::class,
        ];
    }
}
