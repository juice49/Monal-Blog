<?php
namespace Monal\Blog\Models;
/**
 * Blog Post.
 *
 * A contract that a blog post model must implement to be valid.
 *
 * @author  Arran Jacques
 */

use Monal\Data\Models\DataStreamTemplate;
use Monal\Blog\Models\BlogCategory;

interface BlogPost
{
    /**
     * Constructor.
     *
     * @param   Monal\Data\Models\DataStreamTemplate
     *          The data stream template from which we are going to build
     *          the blog post.
     *
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
     * Return a collection of categories that the blog post belongs to.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function categories();

    /**
     * Return a collection of data sets that make up the blog post.
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
     * Return the blog post's description.
     *
     * @return  String
     */
    public function description();

    /**
     * Return the blog post's keywords.
     *
     * @return  String
     */
    public function keywords();

    /**
     * Return a DateTime object of the date and time that the post was
     * created at.
     *
     * @return  DateTime
     */
    public function createdAt();

    /**
     * Return the blog post's URL.
     *
     * @return  String
     */
    public function URL();

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
     * Set the blog post's description.
     *
     * @param   String
     * @return  Void
     */
    public function setDescription($description);

    /**
     * Set the blog post's keywords.
     *
     * @param   String
     * @return  Void
     */
    public function setKeywords($keywords);

    /**
     * Set a DateTime object of the time the post was created at.
     *
     * @param   DateTime
     * @return  Void
     */
    public function setCreatedAtDate(\DateTime $date);

    /**
     * Add a new category which the blog post will belong to.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Void
     */
    public function addCategory(BlogCategory $category);

    /**
     * Return an array of stylesheets the post requires for it’s view to
     * display correctly.
     *
     * @return  Array
     */
    public function css();

    /**
     * Return an array of scripts the post requires for it’s view to
     * function correctly.
     *
     * @return  Array
     */
    public function scripts();

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