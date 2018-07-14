<?php
/**
 * Created by PhpStorm.
 * User: sureshkatwal
 * Date: 14/07/2018
 * Time: 15:28
 */

namespace App\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

class ArticleController
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
        return new Response(sprintf(
            'this is my article: %s',
            $slug
        ));
    }

}