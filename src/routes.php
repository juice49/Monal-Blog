<?php

// Admin routes.
Monal\API\Routes::addAdminRoute(
	'any',
	'blog/posts',
	'admin.blog.posts',
	'BlogPostsController@posts'
);

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/posts/create',
	'admin.blog.posts.create',
	'BlogPostsController@create'
);

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/posts/edit/{id}',
	'admin.blog.posts.edit',
	'BlogPostsController@edit'
);

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/categories',
	'admin.blog.categories',
	'BlogCategoriesController@categories'
);

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/categories/create',
	'admin.blog.categories.create',
	'BlogCategoriesController@create'
);

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/categories/edit/{id}',
	'admin.blog.categories.edit',
	'BlogCategoriesController@edit'
);

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
*/

$blog_accessor_slug = Config::get('blog::config.slug');

// Main blog page.
Route::any(
	$blog_accessor_slug,
	array(
		'as' => 'blog',
		'uses' => 'FrontendBlogController@blog',
	)
);

// Blog post page.
Route::any(
	$blog_accessor_slug . '/{slug}',
	array(
		'as' => 'blog.post',
		'uses' => 'FrontendBlogController@post',
	)
);

// Blog archive and rss pages.
Route::any(
	$blog_accessor_slug . '/{slug_1}/{slug_2}',
	function($slug_1, $slug_2) {
		// Since several blog pages have the same url structure we need to
		// check each part of the url to work out the correct controller to
		// route to.
		switch ($slug_1) {
			case 'rss':
				$controller = \App::make('BlogRSSController');
				return $controller->feed();
				break;
			default:
				if (
					ctype_digit((string) $slug_1) AND
					strlen($slug_1) == 4
				) {
					$controller = \App::make('FrontendBlogController');
					return $controller->postsByMonth($slug_1, $slug_2);
				}
				break;
		}
	}
);