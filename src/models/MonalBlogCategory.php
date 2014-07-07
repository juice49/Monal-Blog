<?php
/**
 * Monal Blog Category.
 *
 * An implementation of the BlogCategory model interface.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Models;

use Monal\Models\Model;
use Monal\Blog\Models\BlogCategory;

class MonalBlogCategory extends Model implements BlogCategory
{
    /**
     * The blog category's properties.
     *
     * @var     Integer
     */
    protected $properties = array();

    /**
     * Constructor.
     *
     * @return  Void
     */
    public function __construct()
    {
        // Set the categories's fixed properties.
        $this->properties['id'] = null;
        $this->properties['name'] = null;
    }

    /**
     * Return the blog category's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return $this->properties['id'];
    }

    /**
     * Return the blog category's name.
     *
     * @return  String
     */
    public function name()
    {
        return $this->properties['name'];
    }

    /**
     * Set the blog category's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->properties['id'] = (integer) $id;
    }

    /**
     * Set the blog category's name.
     *
     * @param   String
     * @return  Void
     */
    public function setName($name)
    {
        $this->properties['name'] = $name;
    }

    /**
     * Check the blog category validates against a set of given rules.
     *
     * @param   Array
     * @param   Array
     * @return  Boolean
     */
    public function validates(array $validation_rules = array(), array $validation_messages = array())
    {
        // Validate the blog category against the given rules.
        $validation = \Validator::make($this->properties, $validation_rules, $validation_messages);
        if ($validation->passes()) {
            return true;
        } else {
            $this->messages->merge($validation->messages());
            return false;
        }
    }

    /**
     * Return a view of the blog category.
     *
     * @param   Array
     * @return  Illuminate\View\View
     */
    public function view(array $settings = array())
    {
        $category = $this->properties;

        // Define the view’s settings using those passed as a param.
        $show_validation = isset($settings['show_validation']) ? $settings['show_validation'] : false;

        // Get the blog category's messages.
        $messages = $this->messages;

        // Build and return a view of the blog category.
        return \View::make(
            'blog::models.category',
            compact(
                'messages',
                'category',
                'show_validation'
            )
        );
    }
}