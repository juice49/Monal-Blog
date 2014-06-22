<?php
/**
 * Blog Posts Controller.
 *
 * This is the controller for requests to the Blog package’s
 * posts dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class BlogPostsController extends AdminController
{
    /**
     * Process requests to the posts admin dashboard and output a
     * response.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function posts()
    {
        if (!$this->system->user->hasAdminPermissions('blog')) {
            return Redirect::route('admin.dashboard');
        }
        $posts = BlogPostsRepository::retrieve();
        $messages = $this->system->messages->merge(FlashMessages::all());
        return View::make('blog::posts.posts', compact('messages', 'posts'));
    }

    /**
     * Process requests to the create blog post admin dashboard and
     * output a response.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!$this->system->user->hasAdminPermissions('blog', 'create_blog_post')) {
            return Redirect::route('admin.blog.posts');
        }
        $post = BlogPostsRepository::newModel();
        if ($this->input) {
            $post->setUser($this->system->user->id);
            $post->setTitle(isset($this->input['title']) ? $this->input['title'] : null);
            $post->setSlug(isset($this->input['slug']) ? $this->input['slug'] : null);
            $data_set_values = \DataSetsHelper::extractDataSetValuesFromInput($this->input);
            $post->dataSets()[0]->component()->setValues($data_set_values[0]['component_values']);
            $post->dataSets()[1]->component()->setValues($data_set_values[1]['component_values']);
            $post->dataSets()[2]->component()->setValues($data_set_values[2]['component_values']);
            if (BlogPostsRepository::write($post)) {
                FlashMessages::flash('success', 'You successfully created to blog post ' . $this->input['title'] . '.');
                return Redirect::route('admin.blog.posts');
            }
            $this->system->messages->merge(BlogPostsRepository::messages());
        }
        foreach ($post->css() as $css) {
            $this->system->dashboard->addCSS($css);
        }
        foreach ($post->scripts() as $script) {
            $this->system->dashboard->addScript($script);
        }
        $messages = $this->system->messages->merge(FlashMessages::all());
        return View::make('blog::posts.create', compact('messages', 'post'));
    }

    /**
     * Process requests to the edit blog post admin dashboard and output
     * a response.
     *
     * @param   Integer
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if (!$this->system->user->hasAdminPermissions('blog', 'edit_blog_post')) {
            return Redirect::route('admin.blog.posts');
        }
        if ($post = BlogPostsRepository::retrieve($id)) {
            if ($this->input) {
                $post->setTitle(isset($this->input['title']) ? $this->input['title'] : null);
                $post->setSlug(isset($this->input['slug']) ? $this->input['slug'] : null);
                $data_set_values = \DataSetsHelper::extractDataSetValuesFromInput($this->input);
                $post->dataSets()[0]->component()->setValues($data_set_values[0]['component_values']);
                $post->dataSets()[1]->component()->setValues($data_set_values[1]['component_values']);
                $post->dataSets()[2]->component()->setValues($data_set_values[2]['component_values']);
                if (BlogPostsRepository::write($post)) {
                    FlashMessages::flash('success', 'You successfully updated to blog post ' . $this->input['title'] . '.');
                    return Redirect::route('admin.blog.posts');
                }
                $this->system->messages->merge(BlogPostsRepository::messages());
            }
            foreach ($post->css() as $css) {
                $this->system->dashboard->addCSS($css);
            }
            foreach ($post->scripts() as $script) {
                $this->system->dashboard->addScript($script);
            }
            $messages = $this->system->messages->merge(FlashMessages::all());
            return View::make('blog::posts.edit', compact('messages', 'post'));
        }
        return Redirect::route('admin.blog.posts');
    }
}