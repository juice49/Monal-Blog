@extends('../dashboard')
@section('body-header')
	<h1 class="dashboard__title">Blog Categories</h1>
@stop
@section('body-content')

	@if($system_user->hasAdminPermissions('blog', 'create_blog_category'))
		<div class="align--right">
			<a href="{{ URL::route('admin.blog.categories.create') }}" class="button button--wasabi">Create category</a>
		</div>
	@endif

	@if ($messages->any())
		<div class="node__y--top">
			@if ($messages->has('success'))
				<div class="message_box message_box--wasabi">
					<span class="message_box__title">Woot!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div>
			@else
				<div class="message_box message_box--tomato">
					<span class="message_box__title">Great Scott!</span>
					<ul>
						@foreach($messages->all() as $message)
							<li>{{ $message }}</li>
						@endforeach
					</ul>
				</div> 
			@endif
		</div>
	@endif

	<div class="node__y--top">
		<div class="wall__tiles">
			@foreach ($blog_categories as $category)
				<div class="tile">
					<div class="tile__content">
						<ul class="tile__properties">
							<li class="tile__property">
								<span class="tile__property__key">Name:</span>
								<span class="tile__property__value">{{ $category->name() }}</span>
							</li>
						</ul>
						<div class="node__y--top align--right">
							@if($system_user->hasAdminPermissions('blog', 'edit_blog_category'))
								<a href="{{ URL::route('admin.blog.categories.edit', $category->ID()) }}" class="button button--small button--dusk">Edit</a>
							@endif
							@if($system_user->hasAdminPermissions('blog', 'delete_blog_category'))
								<span class="button button--small button--cuban_heat">Delete</span>
							@endif
						</div>
					</div>
				</div>
			@endforeach
		</div>
	</div>

@stop