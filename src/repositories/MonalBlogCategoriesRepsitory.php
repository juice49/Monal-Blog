<?php
namespace Monal\Blog\Repositories;
/**
 * Monal Blog Categories Repository.
 *
 * An implementation of the BlogCategoriesRepository.
 *
 * @author  Arran Jacques
 */

use Monal\Repositories\Repository;
use Monal\Blog\Repositories\BlogCategoriesRepository;
use Monal\Blog\Models\BlogCategory;

class MonalBlogCategoriesRepository extends Repository implements BlogCategoriesRepository
{
    /**
     * The database table the repository uses.
     *
     * @var     String
     */
    protected $table = 'blog_categories';

    /**
     * Return a new Blog Category model.
     *
     * @return  Monal\Blog\Models\BlogCategory
     */
    public function newModel()
    {
        return \App::make('Monal\Blog\Models\BlogCategory');
    }

    /**
     * Check a Blog Category model validates for storage.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Boolean
     */
    public function validatesForStorage(BlogCategory $category)
    {
        // Allow A-Z, 0-9, hypens, underscores, commas, ampersands,
        // apostrophes and space characters.
        \Validator::extend('blog_category_name', function($attribute, $value, $parameters)
        {
            return preg_match('/^[a-z0-9 \-_,\'&]+$/i', $value);
        });

        // Build validation rules and messages.
        $unique_exception = ($category->ID()) ? ',' . $category->ID() : null;
        $validation_rules = array(
            'name' => 'required|max:100|blog_category_name|unique:blog_categories,name' . $unique_exception,
        );
        $validation_messages = array(
            'name.required' => 'You need to give this blog category a name.',
            'name.max' => 'The name you have given this blog category is invalid. it must be no more than 100 characters long.',
            'name.blog_category_name' => 'The name you have given this blog category contains invalid characters. The characters allowed are A-Z, 0-9, hypens, underscores, commas, ampersands, apostrophes and spaces.',
            'name.unique' => 'There is already a blog category using this name.',
        );

        // Validate the blog cateogry.
        if ($category->validates($validation_rules, $validation_messages)) {
            return true;
        } else {
            $this->messages->merge($category->messages());
            return false;
        }
    }

    /**
     * Encode a Blog Category model so it is ready to be stored in the
     * repository.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Array
     */
    protected function encodeForStorage(BlogCategory $category)
    {
        return array(
            'name' => $category->name(),
        );
    }

    /**
     * Decode a Blog Category repository entry into its model class.
     *
     * @param   stdClass
     * @return  Monal\Blog\Models\BlogCategory
     */
    protected function decodeFromStorage($result)
    {
        $category = $this->newModel();
        $category->setID($result->id);
        $category->setName($result->name);
        return $category;
    }

    /**
     * Retrieve an instance/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogCategory
     */
    public function retrieve($key = null)
    {
        $query = \DB::table($this->table);
        if (!$key) {
            $results = $query->select('*')->get();
            $blog_categories = \App::make('Illuminate\Database\Eloquent\Collection');
            foreach ($results as $result) {
                $blog_categories->add($this->decodeFromStorage($result));
            }
            return $blog_categories;
        } else {
            if ($result = $query->where('id', '=', $key)->first()) {
                return $this->decodeFromStorage($result);
            }
        }
        return false;
    }

    /**
     * Write a Blog Category model to the repository.
     *
     * @param   Monal\Blog\Models\BlogCategory
     * @return  Boolean
     */
    public function write(BlogCategory $category)
    {
        if ($this->validatesForStorage($category)) {
            $encoded = $this->encodeForStorage($category);
            if ($category->ID()) {
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->where('id', '=', $category->ID())->update($encoded);
                return true;
            } else {
                $encoded['created_at'] = date('Y-m-d H:i:s');
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->insert($encoded);
                return true;
            }
        }
        return false;
    }
}