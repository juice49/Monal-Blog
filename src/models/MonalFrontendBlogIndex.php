<?php
namespace Monal\Blog\Models;
/**
 * Blog Post.
 *
 * This is a model for the Frontend blog index page.
 *
 * @author  Arran Jacques
 */
use Monal\Blog\Models\ToPage;

class MonalFrontendBlogIndex implements ToPage
{
    /**
     * The page's slug.
     *
     * @var     String
     */
    protected $slug;

    /**
     * Constructor.
     *
     * @return  Void
     */
    public function __construct()
    {
        $this->slug = \Config::get('blog::config.slug');
    }

    /**
     * Return the pages's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Return the pages's title.
     *
     * @return  String
     */
    public function title()
    {
        return 'Blog';
    }

    /**
     * Return the pages's description.
     *
     * @return  String
     */
    public function description()
    {
        return '';
    }

    /**
     * Return the pages's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return '';
    }

    /**
     * Return the pages's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return  \URL::to($this->slug());
    }
}