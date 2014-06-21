<?php
namespace Monal\Blog\Repositories;
/**
 * Blog Categories Repository.
 *
 * Repository for storing Blog Categories. This is a contract for
 * implementations of this repository to follow.
 *
 * @author  Arran Jacques
 */

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
     * Return a new Blog Category model.
     *
     * @return  Monal\Blog\Models\BlogCategory
     */
    public function newModel();

    /**
     * Check a Blog Category model validates for storage.
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
     * Write a Blog Category model to the repository.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Boolean
     */
    public function write(BlogCategory $category);
}