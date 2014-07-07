<?php
/**
 * Blog 
 *
 * Library of methods to make retrieving blog posts and other
 * information about the blog easy from within front-end pages.
 *
 * @author	Arran Jacques
 */

namespace Monal\Blog\Libraries;

class Blog
{
	/**
	 * Return the latest blog post.
	 *
	 * @return	Monal\Blog\Models\FrontendBlogPost / Boolean
	 */
	public function latestPost()
	{
		if ($post = \BlogPostsRepository::retrieveLatest()) {
			return \App::make('Monal\Blog\Models\FrontendBlogPost', array($post));
		}
		return false;
	}
}