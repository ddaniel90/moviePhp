<?php require_once './includes/header.php'; ?>
<?php $movie_id = $_GET['movie_id']; ?>
<?php // $movies_filter = array_filter($movies, 'find_movie_by_id'); // $movie = reset($movies_filter);

if (!empty($_GET['movie_id'])) {
	//functia de gasire a filmului dupa id
	$movies_filter = array_filter($movies, function ($item) {
		if ($item['id'] == (int) $_GET['movie_id']) {
			return $item['id'] == (int) $_GET['movie_id'];
		} else {
			return false;
		}
	});
	if ($movies_filter === []) {
		die('ID-ul filmului nu este');
	}
} else {
	die('Nu am gasit nimic ! M-ai incearca');
}
if (isset($_COOKIE['fav_movies'])) {
	$fav_movies = json_decode($_COOKIE['fav_movies'], true);
} else {
	$fav_movies = [];
}


if (isset($_POST['adauga'])) {
	$movie_id = [(int)$_GET['movie_id'] => (int)$_POST['fav']];

	if (isset($_COOKIE['fav_movies'])) {
		foreach (json_decode($_COOKIE['fav_movies'], true) as $key => $val) {
			if ((int)$key == (int)$_GET['movie_id']) {
				$movie_id = array_replace($movie_id, [$_GET['movie_id'] => $val + $_POST['fav']]);
			} else {
				$movie_id = $movie_id + [$key => $val];
			}
		}
		//var_dump($movie_id);
		setcookie("fav_movies", json_encode($movie_id), (time() + 31536000), "/");
	} else {
		setcookie("fav_movies", json_encode($movie_id), (time() + 31536000), "/");
	}
	incrementJson($_GET['movie_id']);
}

if (isset($_POST['remove'])) {
	if (isset($_COOKIE['fav_movies'])) {
		$movie_id = [];
		foreach (json_decode($_COOKIE['fav_movies'], true) as $key => $val) {
			if ((int)$key == (int)$_GET['movie_id']) {
				$movie_id = ['remove' => $_POST['fav']];
			}
			$movie_id = $movie_id + [$key => $val];
		}
		//var_dump($movie_id);
		setcookie("fav_movies", json_encode($movie_id), (time() + 31536000), "/");
	}
	decrementJson($_GET['movie_id']);
}



foreach ($movies_filter as $key => $movie) { ?>
	<!-- Card Section -->
	</div>
	<div class="how-section1">
		<div class="row">
			<h1 class="fs-1 h1text "><?php echo $movie['title']; ?></h1>
			<div class="col-md-3 how-img">
				<img src="<?php echo $movie['posterUrl']; ?>" class="pull-left mr-2" />
			</div>
			<div class="col-md-8 fs-5">
				<div class="row justify-content-between">
					<div class="col-auto">
						<h4><?php echo $movie['year']; ?></h4>
					</div>
					<div class="col-auto">

						<form action="" method="POST">
							<?php if (array_key_exists($_GET['movie_id'], $fav_movies)) { ?>
								<input name="fav" type="hidden" value="0">
								<button type="submit" class="btn position-relative btn-danger" name="remove">Sterge
									<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
										<?php echo get_count_fav($_GET['movie_id']); ?>
										<span class="visually-hidden"><?php echo $current_movie_fav_stats; ?></span>
									<?php } else { ?></span></button>
								<input name="fav" type="hidden" value="1">
								<button type="submit" class="btn position-relative btn-success" name="adauga">Adauga
									<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
										<?php echo get_count_fav($_GET['movie_id']); ?>
										<span class="visually-hidden"><?php echo $current_movie_fav_stats; ?></span>
									<?php } ?></span></button>
								<!-- <button type="submit" class="btn position-relative btn-danger">
								<?php echo in_array($_GET['movie_id'], $fav_movies)
									? 'Sterge din favorite'
									: 'Adauga la favorite'; ?>
								<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
									<?php echo $current_movie_fav_stats = isset($fav_stats[$_GET['movie_id']])
										? $fav_stats[$_GET['movie_id']]
										: 0; ?>
									<span class="visually-hidden"><?php echo $current_movie_fav_stats; ?></span>
								</span>
							</button> -->
						</form>
						<div class="pb-4 fs-6">

						</div>

					</div>
				</div>

				<p class="text-muted"><?php echo $movie['plot']; ?></p>
				<br />
				<p class="text-muted">
					Directed by : <b><?php echo $movie['director']; ?></b>
					<br />
					<br />
					Runtime: <strong><?php echo runtime_prettier($movie['runtime']); ?></strong>
					<br />
				<p class=""><b>Genuri : </b><?php echo implode(' ,  ', $movie['genres']); ?></p>
				<br />
				</p>
				<?php
				$interests = explode(',', $movie['actors']);
				$uList = 'CAST : <br>';
				$uList .= '<ul>';
				foreach ($interests as $people) {
					$uList .= "<li>$people</li>";
				}
				$uList .= '</ul>';
				echo $uList;
				?>
				<?php include_once './includes/movie-reviews.php'; ?>
			</div>
		</div>
	</div>
	<!-- FOOTER SECTION -->
<?php }
require_once './includes/footer.php';
?>

