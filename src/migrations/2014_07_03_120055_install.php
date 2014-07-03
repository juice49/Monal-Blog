<?php




use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;




class Install extends Migration {




	public function up() {
		
		Schema::create('blog_posts', function($table) {
			$table->increments('id');
			$table->string('title');
			$table->string('slug');
			$table->text('images');
			$table->text('intro');
			$table->text('body');
			$table->integer('user');
			$table->text('description');
			$table->text('keywords');
			$table->timestamps();
		});
		
		Schema::create('blog_categories', function($table) {
			$table->increments('id');
			$table->string('name');
			$table->timestamps();
		});
		
	}




	public function down() {
		Schema::drop('blog_posts');
		Schema::drop('blog_categories');
	}




}