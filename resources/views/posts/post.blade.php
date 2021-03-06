<div class="blog-post">
	<h2 class="blog-post-title">
		<a href="/discussion/{{ $post->id }}">{{ $post->title }}</a>
	</h2>
	<div class="row">
		<div class="col- ml-3">
        	<a href="/public/{{ $post->user->id }}"><img src="/uploads/avatars/{{ $post->user->avatar }}" style="width:px; height:32px; position:relative; 	border-radius:50%"></a>
    	</div>	
    	<div class="col d-flex align-items-center">
    		<p class="blog-post-meta">
    			<a href="/public/{{ $post->user->id }}">{{ $post->user->name }}</a> on {{ $post->created_at->tz('America/Los_Angeles')->toFormattedDateString() }}
			</p>
    	</div>
	</div>
	
	{{ html_entity_decode(strip_tags(str_limit($post->body))) }} 
	<!--{{ str_limit($post->body) }} string limit has add to the line above line 16--> 	
</div>
<hr>