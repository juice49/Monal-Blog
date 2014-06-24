<?php
namespace Monal\Blog\Libraries;
/**
 * API for retrieving blog posts and categories, specifically for use
 * on the front end.
 *
 * @author	Arran Jacque
 */

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