<?php
/**
 * Blog Posts Repository.
 *
 * An interface for a repository that stores blog posts. The
 * interface defines a structure for the repository that ensure all
 * necessary methods for reading and writing posts to the repository
 * are defined.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Repositories;

use Monal\Blog\Models\BlogPost;

interface BlogPostsRepository
{
    /**
     * Return the repositorie's messages.
     *
     * @return  Illuminate\Support\MessageBag
     */
    public function messages();

    /**
     * Return a new blog post model.
     *
     * @return  Monal\Blog\Models\BlogPost
     */
    public function newModel();

    /**
     * Check blog post blog validates for storage in the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function validatesForStorage(BlogPost $post);

    /**
     * Retrieve a blog post/s from the repository.
     *
     * @param   Integer
     *          The ID of the entry you want to retrieve. Leave as null to
     *          return all entries.
     *
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogPost
     */
    public function retrieve($key = null);

    /**
     * Retrieve a single blog post from the repository by its slug.
     *
     * @param   String
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveBySlug($slug);

    /**
     * Retrieve the latest blog post to be added to the repository.
     *
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveLatest();

    /**
     * Retrieve all blog posts in the repository that were published
     * between two given dates.
     *
     * @param   DateTime
     *          A DateTime object set to the earliest pulished date.
     *
     * @param   DateTime
     *          A DateTime object set to the earliest pulished date.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function retrievePostsPublishedBetween(\DateTime $from, \DateTime $to);

    /**
     * Write a blog post to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post);
}