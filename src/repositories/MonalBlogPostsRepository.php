<?php
/**
 * Monal Blog Posts Repository.
 *
 * An implementation of the BlogPostsRepository repository interface.
 *
 * @author  Arran Jacques
 */

namespace Monal\Blog\Repositories;

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
     * Return a new blog post model.
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
        $body_data_set->component()->setSettings(array('type' => 'Standard'));
        $post_template->addDataSetTemplate($body_data_set);

        return \App::make('Monal\Blog\Models\BlogPost', array($post_template));
    }

    /**
     * Check blog post blog validates for storage in the repository.
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
     * Return the properties of a blog post model in a format that can be
     * written to the database.
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
     * Use a set of results returned from a database query to build a new
     * blog post model.
     *
     * @param   stdClass
     * @return  Monal\Blog\Models\BlogPost
     */
    protected function decodeFromStorage($result)
    {
        $post = $this->newModel();
        $post->setID($result->id);
        $post->setSlug($result->slug);
        $post->setURI(\Config::get('blog::slug') . '/' . $result->slug);
        $post->setTitle($result->title);
        $post->setUser($result->user);
        $post->setDescription($result->description);
        $post->setKeywords($result->keywords);
        $post->setCreatedAtDate(new \DateTime($result->created_at));

        // Add data sets to the post.
        $post->dataSets()[0]->component()->setValueFromStoragePreparedValues($result->images);
        $post->dataSets()[1]->component()->setValueFromStoragePreparedValues($result->intro);
        $post->dataSets()[2]->component()->setValueFromStoragePreparedValues($result->body);

        // Add categories to the post.
        foreach ($result->categories as $result_category) {
            $category = \BlogCategoriesRepository::newModel();
            $category->setID($result_category['id']);
            $category->setName($result_category['name']);
            $post->addCategory($category);
        }

        return $post;
    }

    /**
     * Return a select query that can be used to retrieve entries from the
     * repository.
     *
     * @return
     */
    private function retrieveQuery()
    {
        return \DB::table($this->table)
            ->select(
                'blog_posts.id',
                'blog_posts.title',
                'blog_posts.slug',
                'blog_posts.images',
                'blog_posts.intro',
                'blog_posts.body',
                'blog_posts.user',
                'blog_posts.description',
                'blog_posts.keywords',
                'blog_posts.created_at',
                'blog_posts.updated_at',

                'blog_categories.id as category_id',
                'blog_categories.name as category_name',
                'blog_categories.created_at as category_created_at',
                'blog_categories.updated_at as category_updated_at'
            )
            ->leftJoin('blog_category_links', 'blog_posts.id', '=', 'blog_category_links.blog_post_id')
            ->leftJoin('blog_categories', 'blog_category_links.category_id', '=', 'blog_categories.id');
    }

    /**
     * Process results returned when using the retrieveQuery() method and
     * collapse duplicate results into a single result.
     *
     * @param   Array
     *          The array of results to process.
     *
     * @return  Array
     */
    private function collapseResults(array $results)
    {
        $duplicates = array();
        $collapsed_results = array();

        // Loop through the results and process them.
        foreach ($results as $result) {

            // If we have already processed a result that has the same ID as the
            // one we are about to process, then simply add the category
            // properties from this results to the one we have already processed.
            if (isset($duplicates[$result->id])) {
                $collapsed_results[$duplicates[$result->id]]->categories[] = array(
                    'id' => $result->category_id,
                    'name' => $result->category_name,
                );
            } else {

                // If this is the first time we have come across a result with this ID
                // add a new category property to it and store it in the
                // collapsed_results array.
                $result->categories = array(
                    0 => array(
                        'id' => $result->category_id,
                        'name' => $result->category_name,
                    )
                );

                // Make a record that a result with the ID x has already been processed.
                $duplicates[$result->id] = (array_push($collapsed_results, $result) - 1);
            }
        }

        // Return the collapsed results.
        return $collapsed_results;
    }

    /**
     * Retrieve a blog post/s from the repository.
     *
     * @param   Integer
     *          The ID of the entry you want to retrieve. Leave as null to
     *          return all entries.
     *
     * @return  Illuminate\Database\Eloquent\Collection / Monal\Blog\Models\BlogPost
     */
    public function retrieve($key = null)
    {
        // If no key has been provided then get all entries in the repo.
        if (!$key) {

            // Get all entries in the repo.
            $results = $this->retrieveQuery()->orderBy('created_at', 'desc')->get();

            // Loop through the returned entries and encode each one into a
            // BlogPost model.
            $blog_posts = \App::make('Illuminate\Database\Eloquent\Collection');
            foreach ($this->collapseResults($results) as $result) {
                $blog_posts->add($this->decodeFromStorage($result));
            }
            return $blog_posts;
        } else {
            if ($results = $this->retrieveQuery()->where('blog_posts.id', '=', $key)->get()) {
                return $this->decodeFromStorage($this->collapseResults($results)[0]);
            }
        }
        return true;
    }

    /**
     * Retrieve a single blog post from the repository by its slug.
     *
     * @param   String
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveBySlug($slug)
    {
        if ($result = $this->retrieveQuery()->where('slug', '=', $slug)->first()) {
            return $this->decodeFromStorage($this->collapseResults(array($result))[0]);
        }
        return false;
    }

    /**
     * Retrieve the latest blog post to be added to the repository.
     *
     * @return  Monal\Blog\Models\BlogPost / Boolean
     */
    public function retrieveLatest()
    {
        if ($result = $this->retrieveQuery()->orderBy('created_at', 'desc')->first()) {
            return $this->decodeFromStorage($this->collapseResults(array($result))[0]);
        }
        return false;
    }

    /**
     * Retrieve all blog posts in the repository that were published
     * between two given dates.
     *
     * @param   DateTime
     *          A DateTime object set to the earliest pulished date.
     *
     * @param   DateTime
     *          A DateTime object set to the earliest pulished date.
     *
     * @return  Illuminate\Database\Eloquent\Collection
     */
    public function retrievePostsPublishedBetween(\DateTime $from, \DateTime $to)
    {
        $results = $this->retrieveQuery()
            ->whereBetween(
                'blog_posts.created_at',
                array(
                    $from->format('Y-m-d H:i:s'),
                    $to->format('Y-m-d H:i:s')
                )
            )
            ->get();
        // Loop through the returned entries and encode each one into a
        // BlogPost model.
        $posts = \App::make('Illuminate\Database\Eloquent\Collection');
        foreach ($this->collapseResults($results) as $result) {
            $posts->add($this->decodeFromStorage($result));
        }
        return $posts;
    }

    /**
     * Write a blog post to the repository.
     *
     * @param   Monal\Blog\Models\BlogPost
     * @return  Boolean
     */
    public function write(BlogPost $post)
    {
        // Check the blog post validates before writing it to the repo.
        if ($this->validatesForStorage($post)) {

            // If it validates, encode the post and write it to the repo.
            $encoded = $this->encodeForStorage($post);

            // If the blog post has an ID then we will find the post in the repo
            // with the same ID and overwrite it.
            if ($post->ID()) {
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                \DB::table($this->table)->where('id', '=', $post->ID())->update($encoded);
            } else {

                // If the blog post doesn’t have an ID then we will create a new entry
                // in the repo.
                $encoded['created_at'] = date('Y-m-d H:i:s');
                $encoded['updated_at'] = date('Y-m-d H:i:s');
                $post_id = \DB::table($this->table)->insertGetId($encoded);
                $post->setID($post_id);
            }
            
            // Get all existing category links for the blog post.
            $category_links = \DB::table('blog_category_links')->where('blog_post_id', '=', $post->ID())->get();

            // Work out if any categories have been removed form the post, and if
            // so, delete the links from the pivot table.
            $links_to_delete = array();
            foreach ($category_links as $link) {
                $delete_link = true;
                foreach ($post->categories() as $category) {
                    if ($link->category_id == $category->ID()) {
                        $delete_link = false;
                    }
                }
                if ($delete_link) {
                    array_push($links_to_delete, $link->id);
                }
            }
            if (!empty($links_to_delete)) {
                \DB::table('blog_category_links')->whereIn('id', $links_to_delete)->delete();
            }

            // Work out if any categories have been added to the post, and if so,
            // add a new link to the pivot table.
            $links_to_insert = array();
            foreach ($post->categories() as $category) {
                $insert_link = true;
                foreach ($category_links as $link) {
                    if ($link->category_id == $category->ID()) {
                        $insert_link = false;
                    }
                }
                if ($insert_link) {
                    array_push($links_to_insert, array(
                        'blog_post_id' => $post->ID(),
                        'category_id' => $category->ID(),
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            if (!empty($links_to_insert)) {
                \DB::table('blog_category_links')->insert($links_to_insert);
            }

            return true;
        }
        return false;
    }
}