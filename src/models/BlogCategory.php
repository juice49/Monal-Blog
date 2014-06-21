<?php
namespace Monal\Blog\Models;
/**
 * Blog Category.
 *
 * This defines the interface a model of a blog category should
 * implement.
 *
 * @author  Arran Jacques
 */

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
     * Return a view of the model.
     *
     * @param   Array
     * @return  Illuminate\View\View
     */
    public function view(array $settings = array());
}