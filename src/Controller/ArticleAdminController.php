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
        $articleContent = <<<EOF
Spicy **jalapeno bacon** ipsum dolor amet veniam shank in dolore. Ham hock nisi landjaeger cow,
lorem proident [beef ribs](https://baconipsum.com/) aute enim veniam ut cillum pork chuck picanha. Dolore reprehenderit
labore minim pork belly spare ribs cupim short loin in. Elit exercitation eiusmod dolore cow
**turkey** shank eu pork belly meatball non cupim.
Laboris beef ribs fatback fugiat eiusmod jowl kielbasa alcatra dolore velit ea ball tip. Pariatur
laboris sunt venison, et laborum dolore minim non meatball. Shankle eu flank aliqua shoulder,
capicola biltong frankfurter boudin cupim officia. Exercitation fugiat consectetur ham. Adipisicing
picanha shank et filet mignon pork belly ut ullamco. Irure velit turducken ground round doner incididunt
occaecat lorem meatball prosciutto quis strip steak.
Meatball adipisicing ribeye bacon strip steak eu. Consectetur ham hock pork hamburger enim strip steak
mollit quis officia meatloaf tri-tip swine. Cow ut reprehenderit, buffalo incididunt in filet mignon
strip steak pork belly aliquip capicola officia. Labore deserunt esse chicken lorem shoulder tail consectetur
cow est ribeye adipisicing. Pig hamburger pork belly enim. Do porchetta minim capicola irure pancetta chuck
fugiat.
EOF;
        $article = new Article();
        $article->setTitle('This is it')
            ->setSlug('this-is-it-'.time())
            ->setContent($articleContent);
        if(rand(1, 10) > 3){
            $article->setPublishedAt(new \DateTime(
                sprintf('%d days', rand(1, 5))
            ));
        }
        $em->persist($article);
        $em->flush();
        return $this->render('admin/article/index.html.twig',[
            'id' => $article->getId(),
            'slug' => $article->getSlug()
        ]);
    }

}
