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
	public function __construct(BlogPost $post);

    /**
     * Return the post's title.
     *
     * @return  String
     */
    public function title();

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function slug();

    /**
     * Return the post's data sets.
     *
     * @return  stdClass
     */
    public function dataSets();
}