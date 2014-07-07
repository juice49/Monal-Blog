<?php
/**
 * Blog Categories Repository.
 *
 * Repository for storing Blog Categories. This is a contract for
 * implementations of this repository to follow.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Repositories;

use Monal\Blog\Models\BlogCategory;

interface BlogCategoriesRepository
{
    /**
     * Return the repository's messages.
     *
     * @return  Illuminate\Support\MessageBag
     */
    public function messages();

    /**
     * Return a new blog category model.
     *
     * @return  Monal\Blog\Models\BlogCategory
     */
    public function newModel();

    /**
     * Check blog post category model validates for storage in the
     * repository.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Boolean
     */
    public function validatesForStorage(BlogCategory $category);

    /**
     * Retrieve an instance/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogCategory
     */
    public function retrieve($key = null);

    /**
     * Write a blog category model to the repository.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Boolean
     */
    public function write(BlogCategory $category);
}