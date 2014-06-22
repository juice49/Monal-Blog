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

use Monal\Data\Models\DataStreamTemplate;

interface BlogPost
{
    /**
     * Constructor.
     *
     * @param   Monal\Data\Models\DataStreamTemplate
     * @return  Void
     */
    public function __construct(DataStreamTemplate $template);

    /**
     * Return the blog post's ID.
     *
     * @return  Integer
     */
    public function ID();

    /**
     * Return the blog post's title.
     *
     * @return  String
     */
    public function title();

    /**
     * Return the blog post's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the blog post's categories.
     *
     * @return  String
     */
    public function categories();

    /**
     * Return the data sets that make up the blog post.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function dataSets();

    /**
     * Return the ID of the user who created the blog post.
     *
     * @return  Integer
     */
    public function user();

    /**
     * Return an array of CSS files the blog post needs to work.
     *
     * @return  Array
     */
    public function css();

    /**
     * Return an array of JS files the blog post needs to work.
     *
     * @return  Array
     */
    public function scripts();

    /**
     * Set the blog post's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id);

    /**
     * Set the blog post's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title);

    /**
     * Set the blog post's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug);

    /**
     * Set the ID of the user who created the post.
     *
     * @param   Integer
     * @return  Void
     */
    public function setUser($user_id);

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