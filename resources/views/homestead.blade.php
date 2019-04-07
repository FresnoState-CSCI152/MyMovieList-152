@extends ('templates/master')

@section ('content')

<div id="overlay" onclick="off()">
	<br />
	<br />
	<br />
	<br />
	<div class='container-fluid mb-5'>
	<div class='row'>
	<div class='col-3 pb-4'>
	        <img id="movie_image" class='img-fluid shadow' src=''>
	</div>
  	<div class='col-9'>
	<div class="table-responsive">
		<table class='table table-bordered' style="color: white;">
		    <thead>
		    <tr>
		        <th scope='col' style='width: 13%;'>Movie Title</th>
		        <th scope='col'>Movie Description</th>
		        <th scope='col' style='width: 16%;'>Movie Release</th>
		        <th scope='col' style='width: 14%;'>TMDB Score</th>
		    </tr>
		    </thead>

		    <tbody>
		    <tr>
		        <td id="review_title"></td>
		        <td id="review_description"></td>
		        <td id="review_release"></td>
		        <td id="review_tmdb_score"></td>
		    </tr>
		    </tbody>
		</table>
	</div>
</div>
</div>
</div>
</div>

<div class="container">
	<div class="row">
		<div class="col">
			<div class="mx-auto" style="width: 25%;">
				Your List
			</div>
			<div id="top-10-list">
			</div>
		</div>
		<div class="col">
			<div class="mx-auto" style="width: 50%;">
				Top Recommended
			</div>
			<div id="top-recommended">
			</div>
		</div>
		<div class="col">
			<div class="mx-auto" style="width: 75%;">
				Top From TMDB
			</div>
			<div id="top-from-tmdb">
			</div>
		</div>
	</div>
</div>
     
{{-- Script --}}
<script>
	filer_num = 1;
	//Top Ten List
	function fill_my_top_ten(movie_list, tmbd_data){

		var movie_img, movie_title, movie_description, movie_release, tmdb_score;

		tmbd_data.forEach(function(data){
			data.forEach(function(fields){
				if(fields.tmdb_id == movie_list.tmdb_id){
					movie_img = fields.img_path;
					movie_title = fields.title;
					movie_description = fields.description;
					movie_release  = fields.release;
					tmbd_score = fields.tmdb_score;
				}
			});
		});

		//movie_list.tmdb_id

		onButtonArguments = '\'' + String(movie_title) + '\', \'' +  String(movie_img) + '\', \'' + String(movie_description.replace('\'', '')) + '\', \'' + String(movie_release) + '\', \'' + String(tmbd_score) + '\'';

		list_string = '<div class="card"><div class="card-body"><h4 class="card-title border border-dark">' + (filer_num++) + '. &nbsp;&nbsp;' +  movie_title + '</h4><img src="http://image.tmdb.org/t/p/w200'+ movie_img + '" alt="Card image cap" style="height: 10rem; float: left; padding-right: 10px;"><p><b>Your Score: ' + movie_list.user_score + '</b></p><button class="btn btn-primary" onclick="on(' + onButtonArguments + ')">Review Details</button></div></div>'

		$('#top-10-list').append(list_string);
	}


	function get_movie_data(user_id) {
		$.ajaxSetup({          
            headers: {
                "X-CSRF-TOKEN": $("meta[name='csrf-token']").attr("content")
            }
        });

		$.ajax({
			type: "GET",
			url: '/GetMovieData',
			data: {
				'user_id': user_id,
			},
			success: function(data) {
			    console.log(data.data);
			    console.log(data.movie_data);
			    data.data.forEach(function(obj){
			    	fill_my_top_ten(obj, data.movie_data);
			    });
			},
			error: function(errorData) {
				return {};
			},
			dataType: "json",
		});
	};

	get_movie_data({{Auth::user()->id}});

	function on(title, img, description, release, tmbd_score) {
  		document.getElementById("overlay").style.display = "block";
  		$("#movie_image").attr("src",'http://image.tmdb.org/t/p/w200' + img);
  		$("#review_title").text(title);
  		$("#review_description").text(description);
  		$("#review_release").text(release);
  		$("#review_tmdb_score").text(tmbd_score);
	}

	function off() {
  		document.getElementById("overlay").style.display = "none";
	}
</script>

@endsection