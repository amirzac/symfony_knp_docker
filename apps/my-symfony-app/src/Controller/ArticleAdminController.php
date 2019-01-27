<?php

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article/new")
     */
    public function new(EntityManagerInterface $em)
    {
        $article = new Article();
        $article->setTitle('Light Speed Travel 2')
            ->setSlug('light-speed-travel-2')
            ->setContent('Fountain of Youth or Fallacy')
            ->setAuthor('Mike Ferengi')
            ->setImageFilename('asteroid.jpeg')
            ->setPublishedAt(new \DateTime())
        ;

        $em->persist($article);
//        $em->flush();

        return new Response(sprintf(
            'Hiya! New Article id: #%d slug: %s',
            $article->getId(),
            $article->getSlug()
        ));
    }
}