<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 14/07/2018
 * Time: 15:28
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends AbstractController
{

    /**
     * @Route("/")
     * @return Response
     */
    public function homepage(): Response
    {
        return new Response('home page response');
    }

    /**
     * @Route("news/{slug}")
     * @param $slug
     * @return Response
     */
    public function show($slug)
    {
        $comments = [
            'this is first comment',
            'this is second comment',
            'this is third comment'
        ];
        return $this->render('article/show.html.twig', [
            'title' => $slug,
            'comments' => $comments
        ]);
    }

}