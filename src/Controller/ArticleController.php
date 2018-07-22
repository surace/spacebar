<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 14/07/2018
 * Time: 15:28
 */

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
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
     * @param ArticleRepository $repository
     * @Route("/", name="app_homepage")
     * @return Response
     */
    public function homepage(ArticleRepository $repository ): Response
    {
        $articles = $repository->findAllPublished();
        return $this->render('article/homepage.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param Article $article
     * @param SlackClient $slackClient
     * @return Response
     */
    public function show(Article $article, SlackClient $slackClient)
    {
        if($article->getSlug() == 'hellow'){
            $slackClient->sendMessage('suresh', 'i am amazing');
        }
        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }


    /**
     * @Route("news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @return Response
     */
    public function toggleHeart(Article $article, LoggerInterface $logger, EntityManagerInterface $em)
    {
        $logger->info(sprintf('This slug %s is being hearted', $article->getSlug()));
        $article->increamentHearCount();
        $em->flush();
        return new JsonResponse(['hearts' => $article->getHeartCount()]);
    }

}