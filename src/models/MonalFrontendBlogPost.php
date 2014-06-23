<?php
namespace Monal\Blog\Models;
/**
 * Frontend Blog Post.
 *
 * This is a working implementation of the FrontendBlogPost model.
 *
 * @author  Arran Jacques
 */

use Monal\Blog\Models\FrontendBlogPost;
use Monal\Blog\Models\BlogPost;

class MonalFrontendBlogPost implements FrontendBlogPost
{
    /**
     * The post's title.
     *
     * @var     String
     */
    protected $title = null;

    /**
     * The post's slug.
     *
     * @var     String
     */
    protected $slug = null;

    /**
     * A collection of data sets that make up the blog post.
     *
     * @var     stdClass
     */
    protected $data_sets = null;

    /**
     * A unix timestamp of the date the post was created at.
     *
     * @var     String
     */
    protected $created_at = null;

    /**
     * The post's URL.
     *
     * @var     String
     */
    protected $url = null;

    /**
     * Constructor.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Void
     */
    public function __construct(BlogPost $post)
    {
        $this->title = $post->title();
        $this->slug = $post->slug();
        $this->url = $post->URL();
        $this->created_at = $post->createdAt();
        $this->data_sets = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach ($post->dataSets() as $data_set) {
            $value = $data_set->component()->prepareValuesForOutput();
            $this->data_sets->{\Text::snakeCaseString($data_set->name())} = $value;
        }
    }

    /**
     * Return the post's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->slug;
    }

    /**
     * Return the post's data sets.
     *
     * @return  stdClass
     */
    public function dataSets()
    {
        return $this->data_sets;
    }

    /**
     * Return the post's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return $this->url;
    }

    /**
     * Return a DateTime object of the date and time that the post was
     * created at.
     *
     * @return  DateTime
     */
    public function createdAt()
    {
        return $this->created_at;
    } 
}