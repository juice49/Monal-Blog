<?php
namespace Monal\Blog\Models;
/**
 * Blog Post.
 *
 * A model of a blog post.
 *
 * @author  Arran Jacques
 */

use Monal\Models\Model;
use Monal\Blog\Models\BlogPost;
use Monal\Blog\Models\ToPage;
use Monal\Data\Models\DataStreamTemplate;
use Monal\Blog\Models\BlogCategory;

class MonalBlogPost extends Model implements BlogPost, ToPage
{
    /**
     * An array of the blog post’s properties.
     *
     * @var     Array
     */
    protected $properties = array();

    /**
     * Constructor.
     *
     * @param   Monal\Data\Models\DataStreamTemplate
     *          The data stream template from which we are going to build
     *          the blog post.
     *
     * @return  Void
     */
    public function __construct(DataStreamTemplate $template)
    {   
        parent::__construct();

        // Set default values for the post's properties.
        $this->properties['id'] = null;
        $this->properties['title'] = null;
        $this->properties['slug'] = null;
        $this->properties['categories'] = array();
        $this->properties['data_sets'] = \App::make('Illuminate\Database\Eloquent\Collection');
        $this->properties['user'] = null;
        $this->properties['description'] = null;
        $this->properties['keywords'] = null;
        $this->properties['created_at'] = null;

        // Use the data stream template passed to the constructor too set the
        // data sets that will make up the post.
        foreach ($template->dataSetTemplates() as $data_set_template) {
            $this->properties['data_sets']->add(\DataSetsRepository::newModel($data_set_template));
        }
        $this->properties['data_sets'][0]->setName('Images');
        $this->properties['data_sets'][1]->setName('Intro');
        $this->properties['data_sets'][2]->setName('Body');
    }

    /**
     * Return the blog post's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return $this->properties['id'];
    }

    /**
     * Return the blog post's title.
     *
     * @return  String
     */
    public function title()
    {
        return $this->properties['title'];
    }

    /**
     * Return the blog post's slug.
     *
     * @return  String
     */
    public function slug()
    {
        if (!$this->properties['slug'] OR $this->properties['slug'] == '') {
            return \Str::slug($this->properties['title']);
        }
        return strtolower($this->properties['slug']);
    }

    /**
     * Return a collection of categories that the blog post belongs to.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function categories()
    {
        return \App::make('Illuminate\Database\Eloquent\Collection', array($this->properties['categories']));
    }

    /**
     * Return a collection of data sets that make up the blog post.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function dataSets()
    {
        return $this->properties['data_sets'];
    }

    /**
     * Return the ID of the user who created the blog post.
     *
     * @return  Integer
     */
    public function user()
    {
        return $this->properties['user'];
    }

    /**
     * Return the blog post's description.
     *
     * @return  String
     */
    public function description()
    {
        return $this->properties['description'];
    }

    /**
     * Return the blog post's keywords.
     *
     * @return  String
     */
    public function keywords()
    {
        return $this->properties['keywords'];
    }

    /**
     * Return a DateTime object of the date and time that the post was
     * created at.
     *
     * @return  DateTime
     */
    public function createdAt()
    {
        return $this->properties['created_at'];
    }

    /**
     * Return the blog post's URL.
     *
     * @return  String
     */
    public function URL()
    {
        return \URL::to(\Config::get('blog::config.slug') . '/' . $this->properties['slug']);
    }

    /**
     * Set the blog post's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->properties['id'] = (integer) $id;
    }

    /**
     * Set the blog post's title.
     *
     * @param   String
     * @return  Void
     */
    public function setTitle($title)
    {
        $this->properties['title'] = (string) $title;
    }

    /**
     * Set the blog post's slug.
     *
     * @param   String
     * @return  Void
     */
    public function setSlug($slug)
    {
        $this->properties['slug'] = (string) $slug;
    }

    /**
     * Set the ID of the user who created the post.
     *
     * @param   Integer
     * @return  Void
     */
    public function setUser($user_id)
    {
        $this->properties['user'] = (int) $user_id;
    }

    /**
     * Set the blog post's description.
     *
     * @param   String
     * @return  Void
     */
    public function setDescription($description)
    {
        $this->properties['description'] = (string) $description;
    }

    /**
     * Set the blog post's keywords.
     *
     * @param   String
     * @return  Void
     */
    public function setKeywords($keywords)
    {
        $this->properties['keywords'] = (string) $keywords;
    }

    /**
     * Set a DateTime object of the time the post was created at.
     *
     * @param   DateTime
     * @return  Void
     */
    public function setCreatedAtDate(\DateTime $date)
    {
        $this->properties['created_at'] = $date;
    }

    /**
     * Add a new category which the blog post will belong to.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Void
     */
    public function addCategory(BlogCategory $category)
    {
        // Make sure the same category isn’t added multiple times.
        if (!in_array($category, $this->properties['categories'])) {
            array_push($this->properties['categories'], $category);
        }
    }

    /**
     * Return an array of stylesheets the post requires for it’s view to
     * display correctly.
     *
     * @return  Array
     */
    public function css()
    {
        $css = array();
        foreach ($this->properties['data_sets'] as $data_set) {
            $css = array_merge($css, $data_set->component()->css());
        }
        return $css;
    }

    /**
     * Return an array of scripts the post requires for it’s view to
     * function correctly.
     *
     * @return  Array
     */
    public function scripts()
    {
        $scripts = array();
        foreach ($this->properties['data_sets'] as $data_set) {
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
            'title' => $this->properties['title'],
            'slug' => $this->slug(),
            'user' => $this->properties['user'],
        );

        // Validate the blog title against the provided rules.
        $validation = \Validator::make($data, $validation_rules, $validation_messages);
        if ($validation->passes()) {
            return true;
        } else {
            //If the post fails the validation check then merge the validation
            // error messages into the posts messages.
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
        $post = $this->properties;

        // Build the category ID string.
        $category_ids = '';
        foreach ($post['categories'] as $category) {
            $category_ids .= $category->ID() . ',';
        }

        // Get all available blog categories.
        $categories = \BlogCategoriesRepository::retrieve();

        // Define the view’s settings using those passed into the function.
        $show_validation = isset($settings['show_validation']) ? $settings['show_validation'] : false;

        // Get the blog posts's messages.
        $messages = $this->messages;

        // Build and return a view of the model.
        return \View::make(
            'blog::models.post',
            compact(
                'messages',
                'post',
                'category_ids',
                'show_validation',
                'categories'
            )
        );
    }
}