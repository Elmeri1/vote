<?php

session_start();

function test_input($data) {
	$data = trim($data);
	$data = stripslashes($data);
	$data = htmlspecialchars($data);
	return $data;
}

require('config/config.php');
require('config/db.php');

$titleErr = $desccErr = $answersErr = "";
$title = $descc = $answers = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["title"])) {
          $titleErr = "Title is required";
        } else {
          $title = test_input($_POST["title"]);
        }
    
        if (empty($_POST["descc"])) {
            $desccErr = "Desc is required";
          } else {
            $descc = test_input($_POST["descc"]);
          }
    
        if (empty($_POST["answers"])) {
        $answersErr = "Answers is required";
        } else {
        $answers = test_input($_POST["answers"]);
        }
    
    }

    if (strlen($title) > 0 && strlen($descc) > 0)	{

			// Get form data
			$title = mysqli_real_escape_string($conn, $title);
			$descc = mysqli_real_escape_string($conn, $descc);

			$query = "INSERT INTO polls (title, descc) VALUES('$title', '$descc')";
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
    <form action="create.php" method="post">

        <label for="title">Otsikko</label>
        <input type="text" name="title" id="title">
        <span class="error"> <?php echo $titleErr;?></span>

        <label for="desc">Kuvaus</label>
        <input type="text" name="desc" id="desc">
        <span class="error"> <?php echo $desccErr;?></span>

        <textarea name="answers" id="answers"></textarea>
        <span class="error"> <?php echo $answersErr;?></span>
        <input type="submit" value="Luo">

    </form>

</div>

<?php include 'inc/footer.php'; ?>