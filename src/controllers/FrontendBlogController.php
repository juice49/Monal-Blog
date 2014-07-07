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
        // Build a new page template with the appropriate properties.
        $page_template = \App::make('Monal\Models\PageTemplate');
        $page_template->setSlug(\Config::get('blog::slug'));
        $page_template->setURI(\Config::get('blog::slug'));
        $page_template->setTitle('Blog');

        // Use the page template to build a new front-end page.
        $page = \App::make('Monal\Models\Page', array($page_template));;

        // Get all of the blog posts.
        $posts = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach (BlogPostsRepository::retrieve() as $post) {
            $posts->add(\App::make('Monal\Blog\Models\FrontendBlogPost', array($post)));
        }

        // Return a view.
        return View::make('theme::blog.blog', compact('page', 'posts'));
    }

    /**
     * Blog post front-end page.
     *
     * @param   String
     * @return  Illuminate\View\View
     */
    public function post($slug)
    {
        // Get the post from the repository.
        if ($blog_post = \BlogPostsRepository::retrieveBySlug($slug)) {

            // Make a new front-end page from the blog post.
            $page = \App::make('Monal\Models\Page', array($blog_post));

            // Make a new front-end blog post.
            $post = \App::make('Monal\Blog\Models\FrontendBlogPost', array($blog_post));

            // Return a view.
            return View::make('theme::blog.post', compact('page', 'post'));
        }
        // If no post was found then throw a 404 error.
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
        // Build a new page template with the appropriate properties.
        $page_template = \App::make('Monal\Models\PageTemplate');
        $page_template->setSlug(\Config::get('blog::slug'));
        $page_template->setURI(\Config::get('blog::slug'));
        $page_template->setTitle('Blog');

        // Use the page template to build a new front-end page.
        $page = \App::make('Monal\Models\Page', array($page_template));;

        // Get all blog posts published in the requested month.
        $from = new DateTime($year . '-' . $month . '-01 00:00:00');
        $to = new DateTime($from->format('Y-m-t' . ' 23:59:59'));
        $results = BlogPostsRepository::retrievePostsPublishedBetween($from, $to);

        // Create a new FrontendBlogPost model for each blog post retrieved.
        $posts = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach ($results as $result) {
            $posts->add(\App::make('Monal\Blog\Models\FrontendBlogPost', array($result)));
        }

        // Copy the from var so it can be used on the front end.
        $date = $from;

        // Return a view.
        return View::make('theme::blog.month', compact('page', 'posts', 'year', 'month', 'date'));
    }
}