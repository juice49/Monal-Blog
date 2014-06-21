<?php
/**
 * Blog Categories Controller.
 *
 * This is the controller for requests to the Blog package’s
 * categories dashboards.
 *
 * @author  Arran Jacques
 */

use Monal\Monal;

class BlogCategoriesController extends AdminController
{
    public function categories()
    {
        return '/';
    }
}