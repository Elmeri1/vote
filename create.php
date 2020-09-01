<?php

session_start();

require('config/config.php');
require('config/db.php');

$titleErr = $answersErr = "";
$title = $answers = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["title"])) {
          $titleErr = "Otsikko on pakollinen";
        } else {
          $title = ($_POST["title"]);
        }

        if (empty($_POST["answers"])) {
        $answersErr = "Vastaus on pakollinen";
        } else {
        $answers = ($_POST["answers"]);
        }
    }


    if (strlen($title) > 0) {

			// Get form data
			$title = mysqli_real_escape_string($conn, $title);

			$query = "INSERT INTO polls (title) VALUES('$title')";
			if(mysqli_query($conn, $query)){
				header('Location: '.ROOT_URL.'');
			} else {
				echo 'ERROR: '. mysqli_error($conn);
			}

		}


?>

<?php include 'inc/header.php'; ?>

<div class="content update">
	<h2>Luo äänestys</h2>
    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post">

        <label for="title">Otsikko</label>
        <input type="text" name="title" id="title">
        <span class="error"> <?php echo $titleErr;?></span>

        <label for="answers">Vastaukset</label>
        <textarea name="answers" id="answers"></textarea>
        <span class="error"> <?php echo $answersErr;?></span>
        <input type="submit" value="Luo">

    </form>

</div>

<?php include 'inc/footer.php'; ?>