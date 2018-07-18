<?php

namespace App\Controller;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ArticleAdminController extends AbstractController
{
    /**
     * @Route("/admin/article", name="admin_article")
     */
    public function index()
    {
        return $this->render('admin/article/index.html.twig', [
            'controller_name' => 'ArticleAdminController',
        ]);
    }


    /**
     * @Route("/admin/article/new", name="admin_article_new")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(EntityManagerInterface $em)
    {
        die('todo');
//        return $this->render('admin/article/index.html.twig',[
//            'id' => $article->getId(),
//            'slug' => $article->getSlug()
//        ]);
    }

}
