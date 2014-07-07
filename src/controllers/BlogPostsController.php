<?php
/**
 * Blog Posts Controller.
 *
 * Controller for the Blog pacakges admin dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class BlogPostsController extends AdminController
{
    /**
     * Blog posts dashboard.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function posts()
    {
        // Does the user have permission to access this dashboard?
        if (!$this->system->user->hasAdminPermissions('blog')) {
            return Redirect::route('admin.dashboard');
        }

        // Retrieve all of the blog posts form the Blog Posts Repository.
        $posts = BlogPostsRepository::retrieve();

        // Grab all of the system's message.
        $messages = $this->system->messages->merge(FlashMessages::all());

        // Output a response in the form of a view.
        return View::make('blog::posts.posts', compact('messages', 'posts'));
    }

    /**
     * Create blog post dashboard.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Does the user have permission to access this dashboard?
        if (!$this->system->user->hasAdminPermissions('blog', 'create_blog_post')) {
            return Redirect::route('admin.blog.posts');
        }

        // Generate new blog post.
        $post = BlogPostsRepository::newModel();

        // If the user has passed input data then use the values to set the
        // values of the blog post’s properties.
        if ($this->input) {
            $post = BlogHelper::buildBlogPostFromInput($post, $this->input);
            $post->setUser($this->system->user->id);

            // Attempt to write the blog post to the Blog Posts Repository.
            if (BlogPostsRepository::write($post)) {

                // If the post is successfully written to the repository then flash a
                // success message to the user’s session and redirect them to the blog
                // posts dashboard.
                FlashMessages::flash('success', 'You successfully created to blog post ' . $this->input['title'] . '.');
                return Redirect::route('admin.blog.posts');
            }

            // If the post fails to write to the repository then merge the
            // repository’s messages into the system’s messages
            $this->system->messages->merge(BlogPostsRepository::messages());
        }

        // Add any scripts and/or stylesheets that the blog post requires to
        // work/display properly to the dashboard.
        foreach ($post->css() as $css) {
            $this->system->dashboard->addCSS($css);
        }
        foreach ($post->scripts() as $script) {
            $this->system->dashboard->addScript($script);
        }

        // Grab all of the system's message.
        $messages = $this->system->messages->merge(FlashMessages::all());

        // Output a response in the form of a view.
        return View::make('blog::posts.create', compact('messages', 'post'));
    }

    /**
     * Edit blog post dashboard.
     *
     * @param   Integer
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        // Does the user have permission to access this dashboard?
        if (!$this->system->user->hasAdminPermissions('blog', 'edit_blog_post')) {
            return Redirect::route('admin.blog.posts');
        }

        // Grab the blog post to be edited from the Blog Posts Repository.
        if ($post = BlogPostsRepository::retrieve($id)) {

            // If the user has passed input data then use the values to set the
            // values of the blog post’s properties.
            if ($this->input) {
                $post = BlogHelper::buildBlogPostFromInput($post, $this->input);

                // Attempt to write the blog post to the Blog Posts Repository.
                if (BlogPostsRepository::write($post)) {

                    // If the post is successfully written to the repository then flash a
                    // success message to the user’s session and redirect them to the blog
                    // posts dashboard.
                    FlashMessages::flash('success', 'You successfully updated to blog post ' . $this->input['title'] . '.');
                    return Redirect::route('admin.blog.posts');
                }

                // If the post fails to write to the repository then merge the
                // repository’s messages into the system’s messages
                $this->system->messages->merge(BlogPostsRepository::messages());
            }

            // Add any scripts and/or stylesheets that the blog post requires to
            // work/display properly to the dashboard.
            foreach ($post->css() as $css) {
                $this->system->dashboard->addCSS($css);
            }
            foreach ($post->scripts() as $script) {
                $this->system->dashboard->addScript($script);
            }

            // Grab all of the system's message.
            $messages = $this->system->messages->merge(FlashMessages::all());

            // Output a response in the form of a view.
            return View::make('blog::posts.edit', compact('messages', 'post'));
        }

        // If we failed to retrieve the blog post from the repository then
        // redirect the user back to the blog posts dashboard.
        return Redirect::route('admin.blog.posts');
    }
}