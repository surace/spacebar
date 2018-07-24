<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommentAdminController extends Controller
{
    /**
     * @Route("/admin/comment", name="comment_admin")
     */
    public function index(CommentRepository $repository, Request $request, PaginatorInterface $paginator)
    {
        $q = $request->query->get('q');
        $queryBuilder = $repository->getSearchQueryBuilder($q);
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('comment_admin/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
}
