<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <?php
    if (isset($templateParams["scripts"])) {
        echo $templateParams["scripts"];
    }
    ?>
</head>

<body>
    <header>
        <h1><img src="resources/icons/foreground.png" alt="Lipho logo"> - <?php echo $templateParams["title"]; ?></h1>
    </header>
    <main>
        <?php
        if (isset($templateParams["page"])) {
            echo $templateParams["page"];
        }
        ?>
    </main>
    <footer>
        <div class="navbar">
            <a href="index.php"><i class="fa-regular fa-house"></i></a>
            <a href="search.php"><i class="fa-regular fa-magnifying-glass"></i></a>
            <a href="create_post.php"><i class="fa-regular fa-plus"></i></a>
            <a href="notifications.php"><i class="fa-regular fa-bell"></i></a>
            <a href="profile.php"><i class="fa-regular fa-user"></i></a>
        </div>
    </footer>
</body>

</html>
