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
		<div class="js--categories">
		</div>
		{{ Form::hidden('categories', null, array('id' => 'categories')) }}
		{{ Form::select('add_categories', array(), null, array('class' => 'select')) }}
		<span class="js--add_category button button--teal">Add category</span>
	</div>
</div>

@foreach ($post['data_sets'] as $data_set)
	{{ $data_set->view() }}
@endforeach

<script>
(function(window, jQuery) {

	window.all_categories = {
		@foreach ($categories as $key => $category)
			{{ $category->ID() }} : '{{ $category->name() }}'{{ (($key + 1) < $categories->count()) ? ',' : '' }}
		@endforeach
	};

	window.updateCategories = function() {

		var categories_html = '';
		var categories = $('#categories').val().split(',');
		var useable_categories = $.extend({}, all_categories);
		$.each(categories, function(key, value) {
			if (value != '') {
				categories_html += '<span class="button button--dusk">' + all_categories[value] + '</span>';
				delete useable_categories[value];
			}
		});
		$('.js--categories').html(categories_html);

		$('#add_categories').find('option').remove();;
		$.each(useable_categories, function(key, value) {
			$('#add_categories')
				.append($('<option>', {value : key})
				.text(value)); 
		});
	};

	window.setSlugFromTitle = function() {
		$('.js--slug').val(slugify($('.js--name').val()));
	};

	window.postSlug = function() {
			var
				name = $('.js--name').val(),
				slug = $('.js--slug').val(),
				accessor = '{{ Config::get('blog::settings.slug') }}',
				post_slug = (slug.length > 0) ? slug : slugify(name);

			if (accessor == '') {
				post_slug = '/' + post_slug;
			} else {
				post_slug = '/' + accessor + '/' + post_slug;
			}
			$('.js--url').val(post_slug);
	};

	$(document).ready(function(){

		$('.js--add_category').on('click', function() {
			if ($('#add_categories').val() !== null) {
				$('#categories').val(
					$('#categories').val() +
					$('#add_categories').val() + ','
				);
				updateCategories();
			}
		});

		$('.js--name, .js--slug, .js--url').on('keyup', postSlug).on('change', postSlug);
		$('.js--name').on('keyup', setSlugFromTitle).on('change', setSlugFromTitle);
		postSlug();
	});
	updateCategories();

})(window, jQuery)
</script>