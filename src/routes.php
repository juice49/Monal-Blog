<?php

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