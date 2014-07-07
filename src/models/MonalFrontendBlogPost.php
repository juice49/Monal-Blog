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
     * The post's properties.
     *
     * @var     Array
     */
    protected $properties = array();

    /**
     * Constructor.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Void
     */
    public function __construct(BlogPost $post)
    {
        $this->properties['id'] = $post->ID();
        $this->properties['slug'] = $post->slug();
        $this->properties['uri'] = $post->URI();
        $this->properties['title'] = $post->title();
        $this->properties['created_at'] = $post->createdAt();
        $this->properties['data_sets'] = new \stdClass;

        foreach ($post->dataSets() as $data_set) {
            $value = $data_set->component()->prepareValuesForOutput();
            $this->properties['data_sets']->{\Text::snakeCaseString($data_set->name())} = $value;
        }
    }

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function ID()
    {
        return $this->properties['id'];
    }

    /**
     * Return the post's slug.
     *
     * @return  String
     */
    public function slug()
    {
        return $this->properties['title'];
    }

    /**
     * Return the post's URI.
     *
     * @return  String
     */
    public function URI()
    {
        return $this->properties['uri'];
    }

    /**
     * Return the post's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->properties['title'];
    }

    /**
     * Return the date the post was created at.
     *
     * @return  DateTime
     */
    public function createdAt()
    {
        return $this->properties['created_at'];
    } 

    /**
     * Return the post's data sets.
     *
     * @return  stdClass
     */
    public function dataSets()
    {
        return $this->properties['data_sets'];
    }

    /**
     * Return the post's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return \URL::to($this->properties['uri']);
    }
}