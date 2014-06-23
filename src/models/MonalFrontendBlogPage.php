<?php
namespace Monal\Blog\Models;
/**
 * Frontend Blog Page.
 *
 * This is a working implementation of the FrontendBlogPage model.
 *
 * @author  Arran Jacques
 */

use Monal\Blog\Models\FrontendBlogPage;
use Monal\Blog\Models\ToPage;

class MonalFrontendBlogPage implements FrontendBlogPage
{
    /**
     * The page's slug.
     *
     * @var     String
     */
    protected $slug = null;

    /**
     * The page's title.
     *
     * @var     String
     */
    protected $title = null;

    /**
     * The page's description.
     *
     * @var     String
     */
    protected $description = null;

    /**
     * The page's keywords.
     *
     * @var     String
     */
    protected $keywords = null;

    /**
     * The page's URL.
     *
     * @var     String
     */
    protected $url = null;

    /**
     * Constructor.
     *
     * @param
     * @return  Void
     */
    public function __construct(ToPage $convert)
    {
        $this->slug = $convert->slug();
        $this->title = $convert->title();
        $this->description = $convert->description();
        $this->keywords = $convert->keywords();
        $this->url = $convert->URL();
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
        return $this->title;
    }

    /**
     * Return the pages's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Return the pages's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->keywords;
    }

    /**
     * Return the pages's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return $this->url;
    }

    /**
     * Return a meta title for the page.
     *
     * @return  String
     */
    public function metaTitle()
    {
        return $this->title();
    }

    /**
     * Return a meta tag for the page’s description.
     *
     * @return  String
     */
    public function metaDescriptionTag()
    {
        return '<meta name="description" content="' . $this->description() . '" />';
    }

    /**
     * Return a meta tag for the page’s keywords.
     *
     * @return  String
     */
    public function metaKeywordsTag()
    {
        return '<meta name="keywords" content="' . $this->keywords() . '" />';
    }

    /**
     * Return a canonical link for the page.
     *
     * @return  String
     */
    public function canonicalLink()
    {
        return $this->URL();
    }

    /**
     * Return a canonical tag for the page.
     *
     * @return  String
     */
    public function canonicalTag()
    {
        return '<link rel="canonical" href="' . $this->canonicalLink() . '" />';
    }
}