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
     */
    public function newModel();

    /**
     * Check a blog post validates for storage in the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function validatesForStorage(BlogPost $post);

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
     * Retrieve all blog posts published between to given dates.
     *
     * @param   DateTime
     * @param   DateTime
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function retrievePostsPublishedBetween(\DateTime $from, \DateTime $to)

    /**
     * Write a blog post to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post);
}