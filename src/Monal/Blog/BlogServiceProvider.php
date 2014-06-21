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
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		\Monal\API\Dashboard::addMenuOption('Blog', 'Blog Categories', 'blog/categories');
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
