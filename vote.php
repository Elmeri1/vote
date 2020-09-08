<?php

session_start();

require('config/config.php');
require('config/db.php');

// $polls = mysqli_fetch_all($result, MYSQLI_ASSOC);

$query = 'SELECT * FROM polls ORDER BY id DESC';

$result = mysqli_query($conn, $query);

$polls = mysqli_fetch_all($result, MYSQLI_ASSOC);

$poll = "SELECT id, title, answers FROM polls DESC";

$votes = "SELECT votes FROM poll_answers";

// $query = "UPDATE 'poll_answers' SET 'votes'='votes'+1 WHERE 'id'=1 AND poll_id=1"; 

// $result = mysqli_query($conn, $query);

// $vote = "UPDATE 'poll_answers' SET 'votes'='votes'+1 WHERE 'id'=1 AND poll_id=1"; 

if (isset($_POST['submit'])) 
{

    $vote = "UPDATE 'poll_answers' SET 'votes'='votes'+1 WHERE 'id'=1 AND poll_id=1"; 

    $result = mysqli_query($conn, $query);

}

//----------------------------------------------------raja-------------------------------------------//
// include 'functions.php';
// // Connect to MySQL
// $pdo = pdo_connect_mysql();
// // If the GET request "id" exists (poll id)...
// if (isset($_GET['id'])) {
//     // MySQL query that selects the poll records by the GET request "id"
//     $stmt = $pdo->prepare('SELECT * FROM polls WHERE id = ?');
//     $stmt->execute([$_GET['id']]);
//     // Fetch the record
//     $poll = $stmt->fetch(PDO::FETCH_ASSOC);
//     // Check if the poll record exists with the id specified
//     if ($poll) {
//         // MySQL query that selects all the poll answers
//         $stmt = $pdo->prepare('SELECT * FROM poll_answers WHERE poll_id = ?');
//         $stmt->execute([$_GET['id']]);
//         // Fetch all the poll anwsers
//         $poll_answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
//         // If the user clicked the "Vote" button...
//         if (isset($_POST['poll_answer'])) {
//             // Update and increase the vote for the answer the user voted for
//             $stmt = $pdo->prepare('UPDATE poll_answers SET votes = votes + 1 WHERE id = ?');
//             $stmt->execute([$_POST['poll_answer']]);
//             // Redirect user to the result page
//             header ('Location: result.php?id=' . $_GET['id']);
//             exit;
//         }
//     } else {
//         die ('Poll with that ID does not exist.');
//     }
// } else {
//     die ('No poll ID specified.');
// }
// ?>

<?php include 'inc/header.php';?>

<div class="content poll-vote">
	<h2><?=$poll['title']?></h2>
    <form action="vote.php?id=<?=$_GET['id']?>" method="post">
        <?php for ($i = 0; $i < count($votes); $i++): ?>
        <label>
            <input type="radio" name="poll_answer" value="<?=$poll_answers[$i]['id']?>"<?=$i == 0 ? ' checked' : ''?>>
            <?=$poll_answers[$i]['title']?>
        </label>
        <?php endfor; ?>
        <div>
            <input type="submit" value="Vote">
            <a href="result.php?id=<?=$poll['id']?>">View Result</a>
        </div>
    </form>
</div>

<?php include 'inc/footer.php'; ?>