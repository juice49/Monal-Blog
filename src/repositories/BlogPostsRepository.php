<?php
namespace Monal\Blog\Repositories;
/**
 * Blog Posts Repository.
 *
 * Repository for storing Blog Posts. This is a contract for
 * implementations of this repository to follow.
 *
 * @author  Arran Jacques
 */

use Monal\Blog\Models\BlogPost;

interface BlogPostsRepository
{
    /**
     * Return the repository's messages.
     *
     * @return  Illuminate\Support\MessageBag
     */
    public function messages();

    /**
     * Return a new Blog Post model.
     *
     * @return  Monal\Blog\Models\Posts
     */
    public function newModel();

    /**
     * Check a Blog Post model validates for storage.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function validatesForStorage(BlogPost $post);

    /**
     * Retrieve an instance/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogPost
     */
    public function retrieve($key = null);

    /**
     * Retrieve a blog post from the repository by its slug.
     *
     * @param   String
     * @return  Monal\Pages\Models\Page
     */
    public function retrieveBySlug($slug);

    /**
     * Write a Blog Post model to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post);
}