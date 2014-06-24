<?php
namespace Monal\Blog\Repositories;
/**
 * Blog Posts Repository.
 *
 * Blog Posts Repository's interface.
 *
 * @author  Arran Jacques
 */

use Monal\Blog\Models\BlogPost;

interface BlogPostsRepository
{
    /**
     * Return a new blog post model.
     *
     * @return  Monal\Blog\Models\BlogPost
     *
    public function newModel();

    /**
     * Check a blog post validates for storage in the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function validatesForStorage(BlogPost $post);

    /**
     * Encode a blog post so that it can be stored in the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Array
     */
    protected function encodeForStorage(BlogPost $post);

    /**
     * Decode a repository entry into a blog post.
     *
     * @param   stdClass
     * @return  Monal\Blog\Models\BlogPost
     */
    protected function decodeFromStorage($result);

    /**
     * Retrieve a blog post/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogPost
     */
    public function retrieve($key = null);

    /**
     * Retrieve a blog post from the repository by its slug.
     *
     * @param   String
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveBySlug($slug);

    /**
     * Retrieve the most recent blog post added to the repository.
     *
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveLatest();

    /**
     * Write a blog post to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post);
}