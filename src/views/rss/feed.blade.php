{{ '<?xml version="1.0" ?>' }}
<rss version="2.0">
	<channel>
	<title>Blog</title>
	<link>{{ URL::to('/') }}</link>
	<description>Latest blog posts from...</description>
	@foreach ($posts as $post)
		<item>
			<title>{{ $post->title() }}</title>
			<link>{{ URL::to($post->URI()) }}</link>
			<description>{{ $post->description() }}</description>       
			<pubDate>{{ $post->createdAt()->format('Y/m/d') }}</pubDate>
			@foreach ($post->categories() as $category)
				<category>{{ $category->name() }}</category>
			@endforeach
		</item>
	@endforeach
	</channel>
</rss>