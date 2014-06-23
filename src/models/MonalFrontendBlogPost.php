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
     * Constructor.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Void
     */
    public function __construct(BlogPost $post)
    {
        $this->title = $post->title();
        $this->slug = $post->slug();
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
}