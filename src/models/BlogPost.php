<?php
/**
 * Blog Post.
 *
 * An interface for a model of a blog post. The interface defines a
 * structure for the blog post that ensures all necessary properties
 * that make up a blog post can be set and returned.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Models;

use Monal\Data\Models\DataStreamTemplate;
use Monal\Blog\Models\BlogCategory;

interface BlogPost
{
    /**
     * Constructor.
     *
     * @param   Monal\Data\Models\DataStreamTemplate
     *          The data stream template that we will use to build the
     *          data sets that will make up the blog post.
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
     * Return the blog post's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the blog post's URI.
     *
     * @return  String
     */
    public function URI();

    /**
     * Return the blog post's title.
     *
     * @return  String
     */
    public function title();

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
     * Return the date at which the post was created.
     *
     * @return  DateTime
     */
    public function createdAt();

    /**
     * Set the blog post's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id);

    /**
     * Set the blog post's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug);

    /**
     * Set the blog post's URI.
     *
     * @param   String
     * @return  Void
     */
    public function setURI($uri);

    /**
     * Set the blog post's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title);

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
     * Set the ID of the user who created the post.
     *
     * @param   Integer
     * @return  Void
     */
    public function setUser($user_id);

    /**
     * Set the the date at which the post was created.
     *
     * @param   DateTime
     * @return  Void
     */
    public function setCreatedAtDate(\DateTime $date);

    /**
     * Add a category to the blog post.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Void
     */
    public function addCategory(BlogCategory $category);

    /**
     * Remove categories that the post currently belongs to.
     *
     * @return  Void
     */
    public function purgeCategories();

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
     * Return a view of the blog post.
     *
     * @param   Array
     * @return  Illuminate\View\View
     */
    public function view(array $settings = array());
}