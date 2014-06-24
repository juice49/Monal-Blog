<?php
/**
 * Frontend Blog Controller.
 *
 * Controller for front end blog routes.
 *
 * @author  Arran Jacques
 */

use Monal\Pages\Models\Page;

class FrontendBlogController extends BaseController
{
    /**
     * Process requests to front-end blog index page.
     *
     * @return  Illuminate\View\View
     */
    public function blog()
    {
        // Make a new front end blog page.
        $page = \App::make(
            'Monal\Blog\Models\FrontendBlogPage',
            array(
                \App::make('Monal\Blog\Models\MonalFrontendBlogIndex'),
            )
        );

        // Get all of the blog posts.
        $posts = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach (BlogPostsRepository::retrieve() as $post) {
            $posts->add(\App::make('Monal\Blog\Models\FrontendBlogPost', array($post)));
        }

        return View::make('theme::blog.blog', compact('page', 'posts'));
    }

    /**
     * Process requests to front-end blog post page.
     *
     * @param   String
     * @return  Illuminate\View\View
     */
    public function post($slug)
    {
        // Get the post from the repository.
        if ($blog_post = \BlogPostsRepository::retrieveBySlug($slug)) {
            // Make a new front end blog page.
            $page = \App::make('Monal\Blog\Models\FrontendBlogPage', array($blog_post));
            // Make a new front end blog post.
            $post = \App::make('Monal\Blog\Models\FrontendBlogPost', array($blog_post));

            return View::make('theme::blog.post', compact('page', 'post'));
        }
        App::abort('404');
    }

    /**
     * Process requests to front-end posts by month page.
     *
     * @param   String
     * @param   String
     * @return  Illuminate\View\View
     */
    public function postsByMonth($year, $month)
    {
        // Make a new front end blog page.
        $page = \App::make(
            'Monal\Blog\Models\FrontendBlogPage',
            array(
                \App::make('Monal\Blog\Models\MonalFrontendBlogIndex'),
            )
        );

        // Get all blog posts published in the given month.
        $from = new DateTime($year . '-' . $month . '-01 00:00:00');
        $to = new DateTime($from->format('Y-m-t' . ' 23:59:59'));
        $results = BlogPostsRepository::retrievePostsPublishedBetween($from, $to);

        // Create a new FrontendBlogPost model for each blog post retrieved.
        $posts = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach ($results as $result) {
            $posts->add(\App::make('Monal\Blog\Models\FrontendBlogPost', array($result)));
        }

        $date = $from;

        return View::make('theme::blog.month', compact('page', 'posts', 'year', 'month', 'date'));
    }
}