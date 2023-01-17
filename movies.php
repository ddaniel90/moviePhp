<?php require_once './includes/header.php'; ?>
<?php if (isset($_GET['genre']) && in_array($_GET['genre'], $genres)) {
	$genre = $_GET['genre'];
	$movies_list = array_filter($movies, 'find_movies_by_genre');
} else {
	$movies_list = $movies;
} ?>
<!-- HERO SECTION -->
<h1 class="fs-1 text__top">Top Greatest Movies of All Time <?php if (
	isset($genre)
) {
	echo ': ' . $genre;
} ?></h1>
<div class="container">
    <!-- Each card have a movie -->
    <div class="row w-100">
        <?php foreach ($movies as $movie) { ?>
        <?php include './includes/archive-movie.php'; ?>
        <?php } ?>
    </div>
    <!-- ENG MOVIE -->
</div>
<?php require_once './includes/footer.php'; ?>