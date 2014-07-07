<?php
namespace Monal\Blog\Libraries;
/**
 * Blog Helper.
 *
 * A library of helper functions for the blog package.
 *
 * @author  Arran Jacques
 */

use Monal\Blog\Models\BlogPost;

class BlogHelper
{
    /**
     * Set the values for a blog post using input data passed by the user.
     *
     * @param   Monal\Blog\Models\BlogPost
     *          The blog post which we are going to set values for.
     *
     * @param   Array
     *          An array of data with which to set the post's values.
     *
     * @return  Monal\Blog\Models\BlogPost
     */
    public function buildBlogPostFromInput(BlogPost $post, array $input)
    {
        // Set the values for the blog post's core properties.
        $post->setTitle(isset($input['title']) ? $input['title'] : null);
        $post->setSlug(isset($input['slug']) ? $input['slug'] : null);

        // Remove all existing categories from the blog post and re-add them
        // based in the user’s input.
        $post->purgeCategories();
        if (isset($input['categories'])) {
            foreach (explode(',', trim($input['categories'], ',')) as $category_id) {
                if ($category = \BlogCategoriesRepository::retrieve($category_id)) {
                    $post->addCategory($category);
                }
            }
        }

        // Extract any data sets from the input and then use those values to
        // set the values for the post’s data sets.
        $data_set_values = \DataSetsHelper::extractDataSetValuesFromInput($input);
        $post->dataSets()[0]->component()->setValues($data_set_values[0]['component_values']);
        $post->dataSets()[1]->component()->setValues($data_set_values[1]['component_values']);
        $post->dataSets()[2]->component()->setValues($data_set_values[2]['component_values']);

        // Return the post with it's values updated.
        return $post;
    }
}