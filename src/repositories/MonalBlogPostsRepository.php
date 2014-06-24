<?php
namespace Monal\Blog\Repositories;
/**
 * Monal Blog Posts Repository.
 *
 * An implementation of the BlogPostsRepository.
 *
 * @author  Arran Jacques
 */

use Monal\Repositories\Repository;
use Monal\Blog\Repositories\BlogPostRepository;
use Monal\Blog\Models\BlogPost;

class MonalBlogPostsRepository extends Repository implements BlogPostsRepository
{
    /**
     * The database table the repository uses.
     *
     * @var     String
     */
    protected $table = 'blog_posts';

    /**
     * Return a new Blog post model.
     *
     * @return  Monal\Blog\Models\BlogPost
     */
    public function newModel()
    {
        $post_template = \DataStreamTemplatesRepository::newModel();

        // Create image component
        $images_data_set = \DataSetTemplatesRepository::newModel();
        $images_data_set->setComponent(\Components::makeTemplate('images'));
        $post_template->addDataSetTemplate($images_data_set);

        // Create intro component
        $intro_data_set = \DataSetTemplatesRepository::newModel();
        $intro_data_set->setComponent(\Components::makeTemplate('text'));
        $intro_data_set->component()->setSettings(array('type' => 'block'));
        $post_template->addDataSetTemplate($intro_data_set);

        // Create body component
        $body_data_set = \DataSetTemplatesRepository::newModel();
        $body_data_set->setComponent(\Components::makeTemplate('wysiwyg'));
        $body_data_set->component()->setSettings(array('type' => 'standard'));
        $post_template->addDataSetTemplate($body_data_set);

        return \App::make('Monal\Blog\Models\BlogPost', array($post_template));
    }

    /**
     * Check a Blog Post model validates for storage.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function validatesForStorage(BlogPost $post)
    {
        // Allow A-Z, 0-9, hypens, underscores, commas, ampersands,
        // apostrophes and space characters.
        \Validator::extend('blog_post_name', function($attribute, $value, $parameters)
        {
            return preg_match('/^[a-z0-9 \-_,\'&]+$/i', $value);
        });
        // Allow A-Z, 0-9, hypens and underscores characters.
        \Validator::extend('post_slug_chars', function($attribute, $value, $parameters)
        {
            return preg_match('/^[a-z0-9\-_]+$/i', $value) ? true : false;
        });
        // Is whole number.
        \Validator::extend('whole_number', function($attribute, $value, $parameters)
        {
            return ctype_digit((string) $value);
        });

        // Build validation rules and messages.
        $unique_exception = ($post->ID()) ? ',' . $post->ID() : null;
        $validation_rules = array(
            'title' => 'required|max:100|blog_post_name|unique:blog_posts,title' . $unique_exception,
            'slug' => 'required|max:100|post_slug_chars|unique:blog_posts,slug' . $unique_exception,
            'user' => 'required|whole_number',
        );
        $validation_messages = array(
            'title.required' => 'You need to give this blog post a title.',
            'title.max' => 'The title you have given this blog post is invalid. it must be no more than 100 characters long.',
            'title.blog_post_name' => 'The title you have given this blog post is invalid. The characters allowed are A-Z, 0-9, hypens, underscores, commas, ampersands, apostrophes and spaces.',
            'title.unique' => 'There is already a blog posts using this title.',
            'slug.required' => 'You need to give this blog post a slug.',
            'slug.max' => 'The slug you have given this blog post is invalid. it must be no more than 100 characters long.',
            'slug.post_slug_chars' => 'The slug you have given this blog post is invalid. The characters allowed are A-Z, 0-9, hypens and underscores.',
            'slug.unique' => 'There is already a blog posts using this slug.',
            'user.required' => 'You need to set a user as the creator of this post.',
            'user.whole_number' => 'The ID of the user who created this post must be a valid ID.',
        );

        // Validate the blog post.
        if ($post->validates($validation_rules, $validation_messages)) {
            return true;
        } else {
            $this->messages->merge($post->messages());
            return false;
        }
    }

    /**
     * Encode a Blog Post model so it is ready to be stored in the
     * repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Array
     */
    protected function encodeForStorage(BlogPost $post)
    {
        return array(
            'title' => $post->title(),
            'slug' => $post->slug(),
            'images' => $post->dataSets()[0]->component()->prepareValuesForStorage(),
            'intro' => $post->dataSets()[1]->component()->prepareValuesForStorage(),
            'body' => $post->dataSets()[2]->component()->prepareValuesForStorage(),
            'user' => $post->user(),
        );
    }

    /**
     * Decode a Blog Post repository entry into its model class.
     *
     * @param   stdClass
     * @return  Monal\Blog\Models\BlogPost
     */
    protected function decodeFromStorage($result)
    {
        $post = $this->newModel();
        $post->setID($result->id);
        $post->setTitle($result->title);
        $post->setSlug($result->slug);
        $post->setUser($result->user);
        $post->setDescription($result->description);
        $post->setKeywords($result->keywords);
        $post->setCreatedAtDate(new \DateTime($result->created_at));
        $post->setURL(\URL::to(\Config::get('blog::settings.slug') . '/' . $result->slug));
        $post->dataSets()[0]->component()->setValueFromStoragePreparedValues($result->images);
        $post->dataSets()[1]->component()->setValueFromStoragePreparedValues($result->intro);
        $post->dataSets()[2]->component()->setValueFromStoragePreparedValues($result->body);
        return $post;
    }

    /**
     * Retrieve an instance/s from the repository.
     *
     * @param   Integer
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogPost
     */
    public function retrieve($key = null)
    {
        $query = \DB::table($this->table);
        if (!$key) {
            $results = $query->select('*')->get();
            $blog_posts = \App::make('Illuminate\Database\Eloquent\Collection');
            foreach ($results as $result) {
                $blog_posts->add($this->decodeFromStorage($result));
            }
            return $blog_posts;
        } else {
            if ($result = $query->where('id', '=', $key)->first()) {
                return $this->decodeFromStorage($result);
            }
        }
        return false;
    }

    /**
     * Retrieve a blog post from the repository by its slug.
     *
     * @param   String
     * @return  Monal\Pages\Models\Page
     */
    public function retrieveBySlug($slug)
    {
        if ($post = \DB::table($this->table)->where('slug', '=', $slug)->first()) {
            return $this->decodeFromStorage($post);
        }
        return false;
    }

    /**
     * Retrieve the latest blog post added to the repository.
     *
     * @return  Monal\Pages\Models\Page / Boolean
     */
    public function retrieveLatest()
    {
        if ($post = \DB::table($this->table)->orderBy('created_at', 'desc')->first()) {
            return $this->decodeFromStorage($post);
        }
        return false;
    }

    /**
     * Write a Blog Post model to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post)
    {
        if ($this->validatesForStorage($post)) {
            $encoded = $this->encodeForStorage($post);
            if ($post->ID()) {
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->where('id', '=', $post->ID())->update($encoded);
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