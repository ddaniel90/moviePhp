<?php
function runtime_prettier($lenght = 0)
{
	if ($lenght == 0 || !is_numeric($lenght)) {
		return 'No runtime data';
	} elseif ($lenght == 1) {
		return $lenght . ' minute';
	} elseif ($lenght > 1 && $lenght < 60) {
		return $lenght . ' minutes';
	} else {
		$hours = intval($lenght / 60);
		$minutes = $lenght % 60;
		return $hours .
			($hours == 1 ? ' hour ' : ' hours ') .
			$minutes .
			($minutes == 1 ? ' minute ' : ' minutes');
	}
}

function check_old_movie($appearance)
{
	if ($appearance < 2021) {
		return 'FALSE';
	} elseif ($appearance == 2022) {
		return 'Current Year';
	}
}


//FUNCTION THAT GET YOU IN THE MULTY FILMS IN THE JSON
function find_movie_by_id($item)
{
	if (!isset($_GET['movie_id'])) {
		return false;
	}
	if (intval($_GET['movie_id']) === $item['id']) {
		return true;
	} else {
		return false;
	}
}

//function search movie by title
function find_movie_by_title($item)
{
	if (stripos($item['title'], $_GET['s']) === false) {
		return true;
	} else {
		return false;
	}
}


//function nr de voturi
function get_count_fav($id)
{
	$content = json_decode(file_get_contents('assets/movie-favorites.json'), true);
	if (!empty($content[$id])) {
		return $content[$id];
	} else {
		return 0;
	}
}


//functie de incrementare in movie fav json
function incrementJson($id)
{
	$file = 'assets/movie-favorites.json';
	$content = json_decode(file_get_contents($file), true);
	$data = [];
	//var_dump($content);
	if (array_key_exists($id, $content)) {
		foreach ($content as $key => $value) {
			if ($key == $id) {
				$data = $data + [$key => $value + 1];
			}
			$data = $data + [$key => $value];
		}
	} else {
		if (!empty($content)) {
			$data = $content + [$id => 1];
		} else {
			$data = [$id => 1];
		}
	}
	file_put_contents($file, json_encode($data));
}

//decrement jsason
function decrementJson($id)
{
	$file = 'assets/movie-favorites.json';
	$content = json_decode(file_get_contents($file), true);
	$data = [];
	//var_dump($content);
	if (array_key_exists($id, $content)) {
		foreach ($content as $key => $value) {
			if ($key == $id) {
				$data = $data + [$key => $value - 1];
			}
			$data = $data + [$key => $value];
		}
	}
	file_put_contents($file, json_encode($data));
}


// FUNCTIE CONECTARE DB
function db_connect($host = 'localhost', $username = 'php-user', $password = "php-password", $dbname = 'php-proiect')
{
	return mysqli_connect($host, $username, $password, $dbname);
}
