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
     * Process requests to front-end blog route page.
     *
     * @return  Illuminate\Http\RedirectResponse
     */
    public function blog()
    {
        // Make a new front end blog page for the blog route.
        $page = \App::make(
            'Monal\Blog\Models\FrontendBlogPage',
            array(
                \App::make('Monal\Blog\Models\MonalFrontendBlogIndex'),
            )
        );
        // Get all blog posts.
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
     * @return  Illuminate\Http\RedirectResponse
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
}