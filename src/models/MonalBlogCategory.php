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
     * The blog category's ID.
     *
     * @var     Integer
     */
    protected $id = null;

    /**
     * The blog category's name.
     *
     * @var     String
     */
    protected $name = null;

    /**
     * Return the blog category's ID.
     *
     * @return  Integer
     */
    public function ID()
    {
        return $this->id;
    }

    /**
     * Return the blog category's name.
     *
     * @return  String
     */
    public function name()
    {
        return $this->name;
    }

    /**
     * Set the blog category's ID.
     *
     * @param   Integer
     * @return  Void
     */
    public function setID($id)
    {
        $this->id = (integer) $id;
    }

    /**
     * Set the blog category's name.
     *
     * @param   String
     * @return  Void
     */
    public function setName($name)
    {
        $this->name = $name;
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
        // Build the data to validate.
        $data = array(
            'name' => $this->name
        );

        // Validate the blog category against the given rules.
        $validation = \Validator::make($data, $validation_rules, $validation_messages);
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
        // Build blog category object for view.
        $category = new \stdClass;
        $category->name = $this->name;

        // Define view settings.
        $show_validation = isset($settings['show_validation']) ? $settings['show_validation'] : false;

        // Get the blog category's messages.
        $messages = $this->messages;

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