<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <title>$title</title>
            <link href="style.css" rel="stylesheet" type="text/css">
            <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
        </head>
        <body>
        <nav class="navtop">
            <div>
                <h1>Äänestyssovellus</h1>
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="index.php"><i class="fas fa-poll-h"></i>Äänestykset</a>
                    <a href="logout.php" class="nav-link">Kirjaudu ulos</a>
            <?php endif; ?>
            </div>
    

        </nav>

