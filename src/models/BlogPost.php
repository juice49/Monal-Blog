<?php
namespace Monal\Blog\Models;
/**
 * Blog Post.
 *
 * This defines the interface a model of a blog post should
 * implement.
 *
 * @author  Arran Jacques
 */

interface BlogPost
{
    /**
     * Check the blog post validates against a set of given rules.
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