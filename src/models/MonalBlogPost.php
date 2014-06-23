<?php
namespace Monal\Blog\Models;
/**
 * Blog Post.
 *
 * This is a working implementation of the BlogPost model.
 *
 * @author  Arran Jacques
 */

use Monal\Models\Model;
use Monal\Blog\Models\BlogPost;
use Monal\Blog\Models\ToPage;
use Monal\Data\Models\DataStreamTemplate;

class MonalBlogPost extends Model implements BlogPost, ToPage
{
    /**
     * The blog post's ID.
     *
     * @var     Integer
     */
    protected $id = null;

    /**
     * The blog post's title.
     *
     * @var     String
     */
    protected $title = null;

    /**
     * The blog post's slug.
     *
     * @var     String
     */
    protected $slug = null;

    /**
     * A collection of categories the blog post belongs to.
     *
     * @var     Illuminate\Database\Eloquent\Collection
     */
    protected $categories = null;

    /**
     * A collection of data sets that make up the blog post.
     *
     * @var     Illuminate\Database\Eloquent\Collection
     */
    protected $data_sets = null;

    /**
     * The ID of the user who created to post.
     *
     * @var     Integer
     */
    protected $user = null;

    /**
     * The blog post's description.
     *
     * @var     String
     */
    protected $description = null;

    /**
     * The blog post's keywords.
     *
     * @var     String
     */
    protected $keywords = null;

    /**
     * The blog post's URL.
     *
     * @var     String
     */
    protected $url = null;

    /**
     * Constructor.
     *
     * @param   Monal\Data\Models\DataStreamTemplate
     * @return  Void
     */
    public function __construct(DataStreamTemplate $template)
    {   
        parent::__construct();
        $this->categories = \App::make('Illuminate\Database\Eloquent\Collection');
        $this->data_sets = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach ($template->dataSetTemplates() as $data_set_template) {
            $this->data_sets->add(\DataSetsRepository::newModel($data_set_template));
        }
        $this->data_sets[0]->setName('Images');
        $this->data_sets[1]->setName('Intro');
        $this->data_sets[2]->setName('Body');
    }

    /**
     * Return the blog post's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return $this->id;
    }

    /**
     * Return the blog post's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return the blog post's slug.
     *
     * @return  String
     */
    public function slug()
    {
        if (!$this->slug OR $this->slug == '') {
            return \Str::slug($this->title);
        }
        return strtolower($this->slug);
    }

    /**
     * Return the blog post's categories.
     *
     * @return  String
     */
    public function categories()
    {
        return null;
    }

    /**
     * Return the data sets that make up the blog post.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function dataSets()
    {
        return $this->data_sets;
    }

    /**
     * Return the ID of the user who created the blog post.
     *
     * @return  Integer
     */
    public function user()
    {
        return $this->user;
    }

    /**
     * Return the blog post's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->description;
    }

    /**
     * Return the blog post's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->keywords;
    }

    /**
     * Return the blog post's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return $this->url;
    }

    /**
     * Set the blog post's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Set the blog post's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Set the blog post's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Set the ID of the user who created the post.
     *
     * @param   Integer
     * @return  Void
     */
    public function setUser($user_id)
    {
        $this->user = $user_id;
    }

    /**
     * Set the blog post's description.
     *
     * @param   String
     * @return  Void
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Set the blog post's keywords.
     *
     * @param   String
     * @return  Void
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
    }

    /**
     * Set the blog post's URL.
     *
     * @param   String
     * @return  Void
     */
    public function setURL($url)
    {
        $this->url = $url;
    }

    /**
     * Return an array of CSS files the blog post needs to work.
     *
     * @return  Array
     */
    public function css()
    {
        $css = array();
        foreach ($this->data_sets as $data_set) {
            $css = array_merge($css, $data_set->component()->css());
        }
        return $css;
    }

    /**
     * Return an array of JS files the blog post needs to work.
     *
     * @return  Array
     */
    public function scripts()
    {
        $scripts = array();
        foreach ($this->data_sets as $data_set) {
            $scripts = array_merge($scripts, $data_set->component()->scripts());
        }
        return $scripts;
    }

    /**
     * Check the blog post validates against a set of given rules.
     *
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function validates(array $validation_rules = array(), array $validation_messages = array())
    {
        // Build the data to validate.
        $data = array(
            'title' => $this->title,
            'slug' => $this->slug(),
            'user' => $this->user,
        );

        // Validate the blog title against the given rules.
        $validation = \Validator::make($data, $validation_rules, $validation_messages);
        if ($validation->passes()) {
            return true;
        } else {
            $this->messages->merge($validation->messages());
            return false;
        }
    }

    /**
     * Return a view of the model.
     *
     * @param   Array
     * @return  Illuminate\View\View
     */
    public function view(array $settings = array())
    {
        // Build blog post object for view.
        $post = new \stdClass;
        $post->title = $this->title;
        $post->slug = $this->slug;
        $post->categories = $this->categories;
        $post->data_sets = $this->data_sets;

        // Get additional data required for the view.
        $categories = \BlogCategoriesRepository::retrieve();

        // Define view settings.
        $show_validation = isset($settings['show_validation']) ? $settings['show_validation'] : false;

        // Get the blog posts's messages.
        $messages = $this->messages;

        return \View::make(
            'blog::models.post',
            compact(
                'messages',
                'post',
                'show_validation',
                'categories'
            )
        );
    }
}