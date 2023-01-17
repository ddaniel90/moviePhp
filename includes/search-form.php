<form class="d-flex" method="GET" action="./search-results.php">
    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="s" value="<?php if (isset($_GET['s'])) {
        	echo $_GET['s'];
        } ?>" />
    <button class="btn btn-outline-success" type="submit">Search</button>
</form>