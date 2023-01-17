<?php require_once './includes/header.php'; ?>

<?php if (isset($_GET['s']) && strlen($_GET['s']) >= 3) {
	$s = $_GET['s']; ?>
<h1>Search results for: <strong> <?php echo $s; ?></strong></h1>
<?php
$filtererd_movies = array_filter($movies, 'find_movie_by_title');
if (count($filtererd_movies) === 0) { ?>
<p>No results!</p>
<?php include './includes/search-form.php'; ?>
<?php } else { ?>
<div class="row movie-list">
    <?php foreach ($filtererd_movies as $movie) { ?>
    <?php include './includes/archive-movie.php'; ?>
    <?php } ?>
</div>
<?php }
?>
<?php
} elseif (isset($s) && strlen($s) < 3) { ?>
<h1>Invalid Search</h1>
<p>Too short query.</p>
<?php include './includes/search-form.php'; ?>
<?php } else { ?>
<h1>Invalid Search</h1>
<p>This page could not be found. Maybe try a search?</p>
<?php include './includes/search-form.php'; ?>
<?php } ?>
<?php require_once './includes/footer.php'; ?>