<?php
/**
 * Blog Categories Controller.
 *
 * Controller for the Blog Categories admin dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class BlogCategoriesController extends AdminController
{
    /**
     * Blog categroies dashboard.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function categories()
    {
        if (!$this->system->user->hasAdminPermissions('blog')) {
            return Redirect::route('admin.dashboard');
        }
        $blog_categories = BlogCategoriesRepository::retrieve();
        $messages = $this->system->messages->merge(FlashMessages::all());
        return View::make('blog::categories.categories', compact('messages', 'blog_categories'));
    }

    /**
     * Create blog category dashboard.
     *
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        if (!$this->system->user->hasAdminPermissions('blog', 'create_blog_category')) {
            return Redirect::route('admin.blog.categories');
        }
        $category = BlogCategoriesRepository::newModel();
        if ($this->input) {
            $category->setName(isset($this->input['name']) ? $this->input['name'] : null);
            if (BlogCategoriesRepository::write($category)) {
                FlashMessages::flash('success', 'You successfully created the blog category "' . $this->input['name'] . '"');
                return Redirect::route('admin.blog.categories');
            }
            $this->system->messages->merge(BlogCategoriesRepository::messages());
        }
        $messages = $this->system->messages->merge(FlashMessages::all());
        return View::make('blog::categories.create', compact('messages', 'category'));
    }

    /**
     * Edit blog category dashboard.
     *
     * @param   Integer
     * @return  Illuminate\View\View / Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        if (!$this->system->user->hasAdminPermissions('blog', 'edit_blog_category')) {
            return Redirect::route('admin.blog.categories');
        }
        if ($category = BlogCategoriesRepository::retrieve($id)) {
            if ($this->input) {
                $category->setName(isset($this->input['name']) ? $this->input['name'] : null);
                if (BlogCategoriesRepository::write($category)) {
                    FlashMessages::flash('success', 'You successfully updated the blog category "' . $this->input['name'] . '"');
                    return Redirect::route('admin.blog.categories');
                }
                $this->system->messages->merge(BlogCategoriesRepository::messages());
            }
            $messages = $this->system->messages->merge(FlashMessages::all());
            return View::make('blog::categories.edit', compact('messages', 'category'));
        }
        return Redirect::route('admin.blog.categories');
    }
}