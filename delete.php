<?php

if (!isset($_GET['id'])) {
    die('id:n arvoa ei ole asetettu');
}

require('config/config.php');
require('config/db.php');

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM polls WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header('Location: index.php');

?>