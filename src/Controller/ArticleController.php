<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 14/07/2018
 * Time: 15:28
 */

namespace App\Controller;

use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Michelf\MarkdownInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage(): Response
    {
        return $this->render('article/homepage.html.twig');
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param $slug
     * @param MarkdownInterface $markdown
     * @return Response
     */
    public function show($slug, MarkdownParserInterface $markdown, AdapterInterface $cache)
    {
        $comments = [
            'this is first comment',
            'this is second comment',
            'this is third comment'
        ];
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
        $item = $cache->getItem('markdown_'.md5($articleContent));
        if(!$item->isHit()){
            $item->set($markdown->transform($articleContent));
            $cache->save($item);
        }

        $articleContent = $item->get();
        return $this->render('article/show.html.twig', [
            'title' => ucwords(str_replace('-', ' ', $slug)),
            'article_content' => $articleContent,
            'slug' => $slug,
            'comments' => $comments
        ]);
    }


    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @return Response
     */
    public function toggleHeart($slug, LoggerInterface $logger)
    {
        $logger->info(sprintf('This slug %s is being hearted', $slug));
        return new JsonResponse(['hearts' => rand(0, 100)]);
    }

}