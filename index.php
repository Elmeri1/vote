<?php

session_start();

require('config/config.php');
require('config/db.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
}

// Create Query
$query = 'SELECT * FROM polls ORDER BY id DESC';

// Get Result
$result = mysqli_query($conn, $query);

// Fetch Data
$polls = mysqli_fetch_all($result, MYSQLI_ASSOC);

//var_dump($posts);
// Free Result
mysqli_free_result($result);
// Close Connection
mysqli_close($conn);

?>

<?php include 'inc/header.php'; ?>

<div class="content home">
	<h2>Äänestykset</h2>
	<a href="create.php" class="create-poll">Luo äänestys</a>
	<table>
        <thead>
            <tr>
                <td>#</td>
                <td>Otsikko</td>
				<td>Vastaukset</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($polls as $poll):?>
            <tr>
                <td><?=$poll['id']?></td>
                <td><?=$poll['title']?></td>
				<td><?=$poll['answers']?></td>
                <td class="actions">
					<a href="vote.php?id=<?=$poll['id']?>" class="view" title="View Poll"><i class="fas fa-eye fa-xs"></i></a>
                    <a href="delete.php?id=<?php echo $poll['id'];?>" class="trash" title="Delete Poll"><i class="fas fa-trash fa-xs"></i></a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include 'inc/footer.php'; ?>