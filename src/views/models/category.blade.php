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
		{{ Form::label('name', 'Name', array('class' => 'label label--block')) }}
		{{ Form::input('text', 'name', $category['name'], array('class' => 'input__text')) }}
	</div>
</div>