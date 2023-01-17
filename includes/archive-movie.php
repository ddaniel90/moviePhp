<div class="col-12 col-md-6 col-lg-4 mb-4" id="movie-<?php echo $movie[
	'id'
]; ?>">
    <div class="card card__first">
        <h5 class="card-title"> <?php echo $movie['title']; ?></h5>
        <img src="<?php echo $movie[
        	'posterUrl'
        ]; ?>" class="card-img-top" alt="<?php echo $movie['title']; ?>" />
        <div class="card-body">
            <p class="card-text"><?php if (strlen($movie['plot']) < 50) {
            	echo $movie['plot'];
            } else {
            	print substr($movie['plot'], 0, 50) . '...';
            } ?></p>
            <a href="movie.php?movie_id=<?php echo $movie[
            	'id'
            ]; ?>" class="btn btn-primary">View Movie</a>
        </div>
    </div>
</div>