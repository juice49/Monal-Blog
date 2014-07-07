<?php
namespace Monal\Blog;

use Illuminate\Support\ServiceProvider;
use Monal\MonalPackageServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class BlogServiceProvider extends ServiceProvider implements MonalPackageServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Return the package's namespace.
	 *
	 * @return	String
	 */
	public function packageNamespace()
	{
		return 'monal\blog';
	}

	/**
	 * Return the package's details.
	 *
	 * @return	Array
	 */
	public function packageDetails()
	{
		return array(
			'name' => 'Blog',
			'author' => 'Arran Jacques',
			'version' => '0.9.0',
		);
	}

	/**
	 * Install the package.
	 *
	 * @return	Boolean
	 */
	public function install()
	{
		return true;
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('monal/blog');

		// Load in the packages routes.
		include __DIR__ . '/../../routes.php';

		// Add menu options to the dashboard.
		\Monal\API\Dashboard::addMenuOption('Blog', 'Blog Posts', 'blog/posts');
		\Monal\API\Dashboard::addMenuOption('Blog', 'Blog Categories', 'blog/categories');

		// Load facade aliases.
		$loader = \Illuminate\Foundation\AliasLoader::getInstance();
		$loader->alias('BlogCategoriesRepository', 'Monal\Blog\Facades\BlogCategoriesRepository');
		$loader->alias('BlogPostsRepository', 'Monal\Blog\Facades\BlogPostsRepository');
		$loader->alias('Blog', 'Monal\Blog\Facades\Blog');
		$loader->alias('BlogHelper', 'Monal\Blog\Facades\BlogHelper');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		// Bind classes to the IOC.
		$this->app->bind(
			'Monal\Blog\Models\FrontendBlogPost',
			function ($app, $parameters) {
				return new \Monal\Blog\Models\MonalFrontendBlogPost($parameters[0]);
			}
		);
		$this->app->bind(
			'Monal\Blog\Models\BlogPost',
			function ($app, $parameters) {
				return new \Monal\Blog\Models\MonalBlogPost($parameters[0]);
			}
		);
		$this->app->bind(
			'Monal\Blog\Models\BlogCategory',
			function ($app, $parameters) {
				return new \Monal\Blog\Models\MonalBlogCategory;
			}
		);
		$this->app->bind(
			'Monal\Blog\Repositories\BlogPostsRepository',
			function ($app, $parameters) {
				return new \Monal\Blog\Repositories\MonalBlogPostsRepository;
			}
		);
		$this->app->bind(
			'Monal\Blog\Repositories\BlogCategoriesRepository',
			function ($app, $parameters) {
				return new \Monal\Blog\Repositories\MonalBlogCategoriesRepository;
			}
		);

		// Register facade bindings.
		$this->app['BlogPostsRepository'] = $this->app->share(
			function ($app) {
				return \App::make('Monal\Blog\Repositories\BlogPostsRepository');
			}
		);
		$this->app['BlogCategoriesRepository'] = $this->app->share(
			function ($app) {
				return \App::make('Monal\Blog\Repositories\BlogCategoriesRepository');
			}
		);
		$this->app['Blog'] = $this->app->share(
			function ($app) {
				return \App::make('Monal\Blog\Libraries\Blog');
			}
		);
		$this->app['BlogHelper'] = $this->app->share(
			function ($app) {
				return \App::make('Monal\Blog\Libraries\BlogHelper');
			}
		);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
