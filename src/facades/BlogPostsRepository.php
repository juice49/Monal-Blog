<?php
namespace Monal\Blog\Facades;

use Illuminate\Support\Facades\Facade;

class BlogPostsRepository extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return  String
     */
    protected static function getFacadeAccessor() { return 'BlogPostsRepository'; }
}