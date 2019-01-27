<?php

namespace App\DataFixtures;

use App\Entity\Comment;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixture extends BaseFixture implements DependentFixtureInterface
{
    public function loadData(ObjectManager $manager)
    {
        $this->createMany(Comment::class, 100, function (Comment $comment) {
            $comment->setContent($this->faker->sentences(2, true));
            $comment->setAuthorName($this->faker->name);
            $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
            $comment->setIsDeleted($this->faker->boolean(20));

            /* @var Article $article */
            $article = $this->getRandomReference(Article::class);
            $comment->setArticle($article);
        });
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ArticleFixtures::class];
    }
}
