<?php
namespace Monal\Blog\Models;
/**
 * To Page.
 *
 * This defines an interface for models that need to be used on the
 * front end must implement.
 *
 * @author  Arran Jacques
 */

interface ToPage
{
	/**
     * Return the model's slug.
     *
     * @return  String
     */
    public function slug();

	/**
     * Return the model's title.
     *
     * @return  String
     */
    public function title();

    /**
     * Return the model's description.
     *
     * @return  String
     */
    public function description();

    /**
     * Return the model's keywords.
     *
     * @return  String
     */
    public function keywords();

    /**
     * Return the model's URL.
     *
     * @return	String
     */
    public function URL();
}