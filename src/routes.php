<?php

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