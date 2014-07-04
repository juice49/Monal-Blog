<div class="well">
	@if ($show_validation AND $messages->any())
		<div class="message_box message_box--tomato">
			<span class="message_box__title">Great Scott!</span>
			<ul>
				@foreach($messages->all() as $message)
					<li>{{ $message }}</li>
				@endforeach
			</ul>
		</div> 
	@endif
	<div class="control_block">
		{{ Form::label('title', 'Title', array('class' => 'label label--block')) }}
		{{ Form::input('text', 'title', $post['title'], array('class' => 'js--name input__text')) }}
	</div>
	<div class="control_block">
		{{ Form::label('slug', 'Slug', array('class' => 'label label--block')) }}
		<label for="slug" class="label label--block label--description">By default the posts's slug will be its title; however you can override this by specifying a custom slug below.</label>
		{{ Form::input('slug', 'slug', $post['slug'], array('class' => 'js--slug input__text')) }}
	</div>
	<div class="control_block">
		{{ Form::label('url', 'URL', array('class' => 'label label--block')) }}
		{{ Form::input('text', 'url', null, array('class' => 'js--url input__text input__text--disabled')) }}
	</div>
	<div class="control_block">
		{{ Form::label('add_categories', 'Categories', array('class' => 'label label--block')) }}
		<div class="control_block">
			<div class="js--categories tag_block">
			</div>
		</div>
		{{ Form::hidden('categories', $category_ids, array('id' => 'categories')) }}
		{{ Form::select('add_categories', array(), null, array('class' => 'select')) }}
		<span class="js--add_category button button--teal">Add category</span>
	</div>
</div>

@foreach ($post['data_sets'] as $data_set)
	{{ $data_set->view() }}
@endforeach

<script>
(function(window, jQuery) {

	// An object literal of all blog categories available.
	window.all_categories = {
		@foreach ($categories as $key => $category)
			{{ $category->ID() }} : '{{ $category->name() }}'{{ (($key + 1) < $categories->count()) ? ',' : '' }}
		@endforeach
	};

	/**
	 * Update the model view to visually display what categories the post
	 * belongs to.
	 */
	window.updateCategories = function() {

		var categories_html = '',

			// Create an array of category IDs that the post belongs to.
			categories = $('#categories').val().split(','),

			// Copy the object storing all of the available blog categories.
			useable_categories = $.extend({}, all_categories);

		// Loop through the category IDs that the post belongs to.
		$.each(categories, function(key, value) {
			if (value != '') {

				// For each category that the blongs to add a tag to the tag block.
				categories_html += '<span class="tag tag--teal">' + all_categories[value];
				categories_html += '<i data-id="' + value + '" class="js--icon icon icon--left icon--action icon-cross-circle"></i></span>';

				// Once the tag has been added, remove it from the object of usable
				// categories. This prevents a category from being added twice.
				delete useable_categories[value];
			}
		});

		// Append the category tags to the model view.
		$('.js--categories')
			.html(categories_html)
			.find('.js--icon')
			.on('click', function() {
				removeCategory($(this).data('id'));
			});

		// Update the category select input to only display categorys that the
		// post doesn't already belong to.
		$('#add_categories').find('option').remove();;
		$.each(useable_categories, function(key, value) {
			$('#add_categories')
				.append($('<option>', {value : key})
				.text(value)); 
		});
	};

	/**
	 * Unassign a category from a post.
	 */
	window.removeCategory = function(id) {

		// Create an array of category IDs that the post currently belongs to.
		var
			$categories = $('#categories').val().split(','),
			val = '';

		// Loop through the categories that the post currently belongs to and
		// remove the specified category.
		$.each($categories, function(key, value) {
			if (value != id && value != '') {
				val += value + ',';
			}
		})
		$('#categories').val(val);

		// Update the model view to display the new categories.
		updateCategories();
	};

	/**
	 * Set the blog post’s slug to be a slugified version of the post’s
	 * title.
	 */
	window.setSlugFromTitle = function() {
		$('.js--slug').val(slugify($('.js--name').val()));
	};

	/**
	 * Update the URL field to show what the post’s URL will be.
	 */
	window.setPostURL = function() {
			var
				name = $('.js--name').val(),
				slug = $('.js--slug').val(),
				accessor = '{{ Config::get('blog::config.slug') }}',
				post_slug = (slug.length > 0) ? slug : slugify(name);

			if (accessor == '') {
				post_slug = '/' + post_slug;
			} else {
				post_slug = '/' + accessor + '/' + post_slug;
			}
			$('.js--url').val(post_slug);
	};

	// On document load run boot scripts.
	$(document).ready(function(){

		// Bind event to the "Add category" button so users can assign
		// categories to the post
		$('.js--add_category').on('click', function() {
			if ($('#add_categories').val() !== null) {

				// Add the category ID the the hidden category input.
				$('#categories').val(
					$('#categories').val() +
					$('#add_categories').val() + ','
				);

				// Update the GUI so the user can visually see that the post has been
				// assigned to a new category.
				updateCategories();
			}
		});

		// Bind events to update the URL field as the post's title and slug
		// are changed.
		$('.js--name, .js--slug, .js--url').on('keyup', setPostURL).on('change', setPostURL);
		$('.js--name').on('keyup', setSlugFromTitle).on('change', setSlugFromTitle);

		// Set the URL field.
		setPostURL();
	});

	// On view load add category tags to the GUI so the user can see what
	// categorys the post belongs to.
	updateCategories();

})(window, jQuery)
</script>