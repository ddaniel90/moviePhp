<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<?php
$conn = db_connect();
$review_data = array(
    'show_reviews_form' => false
);

if (!$conn) {
    $review_data['show_reviews_form'] = false;
}
//CREARE TABEL IN BAZA DE DATE DACA NU EXISTA 
$sql = "CREATE TABLE IF NOT EXISTS `reviews` (
        `id` INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
        `movie_id` INT(6) UNSIGNED NOT NULL,
        `full_name` varchar(65) NOT NULL,
        `email` varchar(125) NOT NULL,
        `review` TEXT NOT NULL
    );";

if (mysqli_query($conn, $sql)) {
    $review_data['show_reviews_form'] = true;

    $sql_all_review = "SELECT `full_name`, `email` , `review` FROM reviews WHERE `movie_id` = " . $_GET["movie_id"];
    $reviews_list = mysqli_query($conn, $sql_all_review);

    $review_data['count'] = mysqli_num_rows($reviews_list);

    if ($review_data['count'] > 0) {
        $review_data['list'] = mysqli_fetch_all($reviews_list, MYSQLI_ASSOC);
        $reviews_emails = array_column($review_data['list'], 'email');
    }


    if (isset($_POST['reviews_form'])) {
        if (isset($reviews_emails) && in_array($_POST['email'], $reviews_emails)) {
            $review_data['alert'] = 'danger';
            $review_data['message'] = 'Se pare ca ai mai lasat un review la acest film , iti multumim dar nu poti sa lasi mai multe review-uri pentru acelasi film ';
        } else {
            $movie_id = mysqli_real_escape_string($conn, $_GET['movie_id']);
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $review = mysqli_real_escape_string($conn, $_POST['review']);
            $sql = "INSERT INTO `reviews` (`movie_id`, `full_name`, `email` , `review`)
            VALUES ('" . $movie_id . "', '" . $full_name . "' , '" . $email . "', '" . $review . "')";
            //array review data
            if (mysqli_query($conn, $sql)) {
                //daca review a fost adaugat in baza de date cu succes afiseaza mesajul
                $review_data['show_reviews_form'] = false;
                $review_data['alert'] = "success";
                $review_data['message'] = "<strong>Success!</strong>  Formularul trimis cu succes";

                //Reapelare la baza de date
                // $reviews_list = mysqli_query($conn, $sql_all_review);
                // $review_data['list'] = mysqli_fetch_all($reviews_list, MYSQLI_ASSOC);

                //Apelare la lista cu review-uri optimizare la DB 
                $review_data['list'][] = array(
                    'full_name' => $_POST['full_name'],
                    'email' => $_POST['email'],
                    'review' => $_POST['review'],
                );
                $review_data['count']++;
            } else {
                //daca nu sa adaugat review-ul adauga mesajul 
                $review_data['alert'] = "danger";
                $review_data['message'] = "<strong>Error ! </strong> A aparut o eruare. M-ai incearca odata";
            }
        }
    }
}

?>
<br><br>
<?php if (isset($review_data['message']) && isset($review_data['alert'])) { ?>
    <div class="fw-normal alert alert-dismissible fade show mb-5 alert-<?php echo $review_data['alert']; ?> " role="alert">
        <?php echo $review_data['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php } ?>

<!-- Form  de review -->
<?php if ($review_data['show_reviews_form'] == true) { ?>
    <div class="my-3 p-3 bg-light border rounded shadow mb-5 bg-body rounded">
        <div class="h4 mb-3 pb-3 border-bottom">
            <?php
            if ($review_data['count'] > 0) {
                echo 'Lasa un review pentru acest film ! ';
            } else {
                echo 'Fii primul care lasa un review pentru acest film';
            }
            ?>
        </div>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="full_name">Full name</label> <br>
                <input type="text" class="form-control" id="full_name" name="full_name" value="<?php if (isset($_POST['full_name']))
                                                                                                    echo $_POST['full_name']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="email">Email</label><br>
                <input type="email" class="form-control" id="email" name='email' value="<?php if (isset($_POST['email']))
                                                                                            echo $_POST['email']; ?>" required>
            </div>

            <div class="mb-3">
                <label for="review">Review</label><br>
                <textarea class="form-control" id="review" name="review" required><?php if (isset($_POST['full_name']))
                                                                                        echo $_POST['full_name']; ?>
            </textarea>
            </div>

            <div class="mt-2 ml-4 mb-5 form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" id="acceptance flexSwitchCheckDefault" name="acceptance" value="acceptance" required>
                <label class="form-check-label" for="acceptance flexSwitchCheckDefault">Accept termenii de procesare a datelor cu caracter personal</label>
            </div>
            <input type="submit" name="reviews_form" id="btn" class="btn fs-5 btn-primary" value="Trimite">
        </form>
    </div>
<?php } ?>


<!-- Afisare toate review care sunt deja la film -->
<?php if (isset($review_data['count']) && $review_data['count'] > 0) { ?>

    <div class="h2 mt-4 ">Reviews</div>
    <?php
    foreach (array_reverse($review_data['list']) as $review) { ?>
        <div class="my-3 p-3 border">
            <div class="fw-bold pb-3 mb-3 border-bottom">
                <?php echo $review['full_name']; ?>
            </div>
            <?php echo $review['review']; ?>
        </div>
    <?php } ?>
<?php } ?>