<?php
/**
 *  Blog Category.
 *
 * An interface for a model of a blog category. The interface defines
 * a structure for the blog category that ensures all necessary
 * properties that make up a blog category can be set and returned.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Models;

interface BlogCategory
{
    /**
     * Return the blog category's ID.
     *
     * @return  Integer
     */
    public function ID();

    /**
     * Return the blog category's name.
     *
     * @return  String
     */
    public function name();

    /**
     * Set the blog category's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id);

    /**
     * Set the blog category's name.
     *
     * @param   String
     * @return  Void
     */
    public function setName($name);

    /**
     * Check the blog category validates against a set of given rules.
     *
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function validates(array $validation_rules = array(), array $validation_messages = array());

    /**
     * Return a view of the blog category.
     *
     * @param   Array
     * @return  Illuminate\View\View
     */
    public function view(array $settings = array());
}