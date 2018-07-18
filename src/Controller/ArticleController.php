<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 14/07/2018
 * Time: 15:28
 */

namespace App\Controller;

use App\Entity\Article;
use App\Service\MarkdownHelper;
use App\Service\SlackClient;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @var bool
     */
    private $isDebug;

    function __construct(bool $isDebug)
    {
        $this->isDebug = $isDebug;
    }

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
     * @param MarkdownHelper $markdownHelper
     * @return Response
     */
    public function show($slug, SlackClient $slackClient, EntityManagerInterface $em)
    {
        $repository = $em->getRepository(Article::class);
        $article = $repository->findOneBy(['slug' => $slug]);
        $comments = [
            'this is first comment',
            'this is second comment',
            'this is third comment'
        ];
        if(!$article){
            throw $this->createNotFoundException(
                sprintf('Article not found with slug "%s"', $slug)
            );
        }
        if($slug == 'hellow'){
            $slackClient->sendMessage('suresh', 'i am amazing');
        }
        return $this->render('article/show.html.twig', [
            'article' => $article,
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