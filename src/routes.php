<?php

Monal\API\Routes::addAdminRoute(
	'any',
	'blog/categories',
	'admin.blog.categories',
	'BlogCategoriesController@categories'
);