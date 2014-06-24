<?php
namespace Monal\Blog\Libraries;
/**
 * API for retrieving blog posts and categories.
 *
 * @author	Arran Jacque
 */

class Blog
{
	/**
	 * Return the latest blog post.
	 *
	 * @return	Monal\Blog\Models\BlogPost / Boolean
	 */
	public function latestPost()
	{
		return \BlogPostsRepository::retrieveLatest();
	}
}