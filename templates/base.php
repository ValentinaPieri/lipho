<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
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
            <a href="index.php" title="Home Page"><span class="fa-regular fa-house"></span></a>
            <a href="search.php" title="Search Page"><span class="fa-regular fa-magnifying-glass"></span></a>
            <a href="create_post.php" title="Create Post Page"><span class="fa-regular fa-plus"></span></a>
            <a href="notifications.php" title="Notifications Page"><span class="fa-regular fa-bell"></span></a>
            <a href="profile.php" title="Profile Page"><span class="fa-regular fa-user"></span></a>
        </div>
    </footer>
</body>
<?php
if (isset($templateParams["scripts"])) {
    echo $templateParams["scripts"];
}
?>

</html>