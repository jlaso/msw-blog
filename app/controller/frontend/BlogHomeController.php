<?php

use Router\Controller;
use app\models\core\Pagination\Paginable;


class BlogHomeController extends Controller
{

    /**
     * @Route('/blog')
     * @Name('blog_home')
     */
    public function homeAction($page = 1)
    {
        $app = \Slim\Slim::getInstance();
        $paginator    = new Paginable('Entity\\Article', array('recPerPage' => 2));
        $paginator->setBaseRouteAndParams('articles.index');
        if (($page < 1) || ($page > $paginator->getPages())) {
            $app->notFound();
        }
        $paginator->setCurrentPage($page);
        $articles = $paginator->getResults();

        $app->render('@JLaso/Blog:frontend/blog/index.html.twig',array(
                'articles'     => $articles,
                'paginator'    => $paginator,
            ));
//        die('blog home');
    }

    /**
     * @Route('/blog/rss')
     * @Name('blog_rss')
     */

    public function blogRssAction()
    {
        die('RSS');
    }

    /**
     * @Route('/blog/:slug')
     * @Name('blog_post')
     */
    public function postAction($slug)
    {
        die('post ' . $slug . '!');
    }

}