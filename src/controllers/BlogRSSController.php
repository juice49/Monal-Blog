<?php
/**
 * Blog RSS Controller.
 *
 * Controller for the blog's RSS feed.
 *
 * @author  Arran Jacques
 */

use Monal\Pages\Models\Page;

class BlogRSSController extends BaseController
{
	/**
	 *
	 */
	public function feed()
	{
		$posts = BlogPostsRepository::retreiveAmount(3);
		$xml = View::make('blog::rss.feed', compact('posts'));
		return Response::make($xml, '200')->header('Content-Type', 'text/plain');
	}
}