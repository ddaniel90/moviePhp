<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="favicon.png" />
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous" />
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.css" />
    <title>Andrei Daniel</title>
</head>

<body class="d-flex flex-column min-vh-100">
    <?php
    require_once './includes/functions.php';
    //Movie array multidimensional
    if (
        !in_array(basename($_SERVER['PHP_SELF']), ['index.php', 'contact.php'])
    ) {
        $movies = json_decode(
            file_get_contents('./assets/movies-list-db.json'),
            true
        )['movies'];
        $genres = json_decode(
            file_get_contents('./assets/movies-list-db.json'),
            true
        )['genres'];
    }
    //Meniu dinamic array
    $menu_items = [
        [
            'link' => 'index.php',
            'title' => 'Home',
        ],
        [
            'link' => 'movies.php',
            'title' => 'Movies',
        ],
        [
            'link' => 'contact.php',
            'title' => 'Contact Us',
        ],
    ];

    if (isset($_COOKIE['fav_movies'])) {
        $fav_movies = json_decode($_COOKIE['fav_movies'], true);
        if (!empty($fav_movies)) {
            $menu_items[] = [
                'link' => 'movies.php?page=favorites',
                'title' => 'Favorite',
            ];
        }
    }
    ?>
    <nav class="navbar navbar-expand-lg bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="/index.php">
                <?php define('SITE_NAME', 'DN'); ?>
                <img class="favicon" src="favicon.png" alt="logo" />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php foreach ($menu_items as $menu_item) { ?>
                        <li class="nav-item">
                            <a class="nav-link <?php if (
                                                    basename($_SERVER['PHP_SELF']) == $menu_item['link']
                                                ) {
                                                    echo 'aria-current="page"';
                                                } ?>" href="<?php echo $menu_item['link']; ?>"><?php echo $menu_item['title']; ?>
                            </a>
                        </li>
                    <?php } ?>
                </ul>
                <?php include './includes/search-form.php'; ?>
            </div>
        </div>
    </nav>
    <!-- LANDING PAGE -->