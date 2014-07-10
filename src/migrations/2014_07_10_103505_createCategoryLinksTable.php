<?php




use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;




class CreateCategoryLinksTable extends Migration {




	public function up() {
		Schema::create('blog_category_links', function($table) {
			$table->increments('id');
			$table->integer('blog_post_id');
			$table->integer('category_id');
			$table->timestamps();
		});
	}




	public function down() {
		Schema::drop('blog_category_links');
	}




}