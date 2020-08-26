<?php
include 'functions.php';
$pdo = pdo_connect_mysql();
$msg = '';

$titleErr = $descErr = $answersErr = "";
$title = $desc = $answers = "";

if (!empty($_POST)) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["title"])) {
          $titleErr = "Title is required";
        } else {
          $title = test_input($_POST["title"]);
        }
    
        if (empty($_POST["desc"])) {
            $descErr = "Desc is required";
          } else {
            $desc = test_input($_POST["desc"]);
          }
    
        if (empty($_POST["answers"])) {
        $answersErr = "Answers is required";
        } else {
        $answers = test_input($_POST["answers"]);
        }
    
    }

// Check if POST data is not empty

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
        <span class="error"> <?php echo $titleErr;?></span>

        <label for="desc">Kuvaus</label>
        <input type="text" name="desc" id="desc">
        <span class="error"> <?php echo $descErr;?></span>

        <textarea name="answers" id="answers"></textarea>
        <span class="error"> <?php echo $answersErr;?></span>
        <input type="submit" value="Luo">

    </form>
    <?php if ($msg): ?>
    <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer();?>