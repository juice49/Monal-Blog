<?php
namespace Monal\Blog\Models;
/**
 * Frontend Blog Post.
 *
 * A model of a Frontend Blog Post. This is a contract for
 * implementations of this model to follow.
 *
 * @author	Arran Jacques
 */

use Monal\Blog\Models\BlogPost;

interface FrontendBlogPost
{
    /**
     * Constructor.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Void
     */
    public function __construct(BlogPost $post);

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function ID();

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the post's URI.
     *
     * @return  String
     */
    public function URI();

    /**
     * Return the post's title.
     *
     * @return  String
     */
    public function title();

    /**
     * Return the date the post was created at.
     *
     * @return  DateTime
     */
    public function createdAt();

    /**
     * Return the post's data sets.
     *
     * @return  stdClass
     */
    public function dataSets();

    /**
     * Return the post's URL.
     *
     * @return  String
     */
    public function URL();
}