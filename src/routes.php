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

// Frontend routes.
Route::any(
	Config::get('blog::config.slug'),
	array(
		'as' => 'blog',
		'uses' => 'FrontendBlogController@blog',
	)
);

Route::any(
	Config::get('blog::config.slug') . '/{slug}',
	array(
		'as' => 'blog',
		'uses' => 'FrontendBlogController@post',
	)
);

Route::any(
	Config::get('blog::config.slug') . '/{year}/{month}',
	array(
		'as' => 'blog',
		'uses' => 'FrontendBlogController@postsByMonth',
	)
);