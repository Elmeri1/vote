<?php
session_start();
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

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
if (strlen($title) > 0 && strlen($answers) > 0) {
// Check if POST data is not empty
if (!empty($_POST)) {
    // Post data not empty insert a new record
    // Check if POST variable "title" exists, if not default the value to blank, basically the same for all variables
    $title = isset($_POST['title']) ? $_POST['title'] : '';
    // Insert new record into the "polls" table
    $stmt = $pdo->prepare('INSERT INTO polls VALUES (NULL, ?)');
    $stmt->execute([$title]);
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

    header("Location: index.php");
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

        <label for="answers">Vastaukset</label>
        <textarea name="answers" id="answers"></textarea>
        <span class="error"> <?php echo $answersErr;?></span>

        <input type="submit" value="Luo">

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?php include 'inc/footer.php'; ?>