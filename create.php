<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

// // Test if fields are empty
// $titleErr = $descErr = $answersErr "";
// $title = $lähettäjä = $viesti = "";

// // Check For Submit
// if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
//     if (empty($_POST["aihe"])) {
//         $aiheErr = "Aihe on pakollinen";
//     } else {
//         $aihe = test_input($_POST["aihe"]);
//     }

//     if (empty($_POST["lähettäjä"])) {
//         $lähettäjäErr = "Lähettäjä on pakollinen";
//     } else {
//         $lähettäjä = test_input($_POST["lähettäjä"]);
//     }

//     if (empty($_POST["viesti"])) {
//         $viestiErr = "Viesti on pakollinen";
//     } else {
//         $viesti = test_input($_POST["viesti"]);
//     }
    


// if (strlen($aihe) > 0 && strlen($lähettäjä) > 0 && strlen($viesti) > 0)	{

//     // Get form data
//     $aihe = mysqli_real_escape_string($conn, $aihe);
//     $viesti = mysqli_real_escape_string($conn, $viesti);
//     $lähettäjä = mysqli_real_escape_string($conn, $lähettäjä);

//     // Hae pvm php-funktiolla
//     date_default_timezone_set('Europe/Helsinki');
//     $pvm = date("Y-m-d G:i:s ");

//     $query = "INSERT INTO viestit (aihe, lähettäjä, viesti, pvm) VALUES('$aihe', '$lähettäjä', '$viesti', '$pvm')";
//     if(mysqli_query($conn, $query)){
//         header('Location: '.ROOT_URL.'');
//     } else {
//         echo 'ERROR: '. mysqli_error($conn);
//     }

// }


// }





// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "title" exists, if not default the value to blank, basically the same for all variables
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    $desc = isset($_POST['desc']) ? $_POST['desc'] : '';
    // Insert new record into the "polls" table
    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?, ?)');
    $stmt->execute([$title, $desc]);
    // Below will get the last insert ID, this will be the poll id
    $poll_id = $pdo->lastInsertId();
    // Get the answers and convert the multiline string to an array, so we can add each answer to the "poll_answers" table
    $answers = isset($_POST['answers']) ? explode(PHP_EOL, $_POST['answers']) : '';
    foreach ($answers as $answer) {
        // If the answer is empty there is no need to insert
        if (empty($answer)) continue;
        // Add answer to the "poll_answers" table
        $stmt = $pdo->prepare('INSERT INTO poll_answers VALUES (NULL, ?, ?, 0)');
        $stmt->execute([$poll_id, $answer]);
    }
    // Output message
    $msg = 'Created Successfully!';
}
?>

<?=template_header('Create Poll')?>

<div class="content update">
	<h2>Luo äänestys</h2>
    <form action="create.php" method="post">

        <label for="title">Otsikko</label>
        <input type="text" name="title" id="title">
        <!-- <span class="error"> <?php echo $titleErr;?></span> -->

        <label for="desc">Kuvaus</label>
        <input type="text" name="desc" id="desc">
        <label for="answers">Vastaukset</label>
        <!-- <span class="error"> <?php echo $descErr;?></span> -->

        <textarea name="answers" id="answers"></textarea>
        <input type="submit" value="Luo">
        <!-- <span class="error"> <?php echo $answersErr;?></span> -->


    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer()?>