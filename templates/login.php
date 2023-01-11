<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
</head>

<body>
    <main>
        <div class="page">
            <div class="header">
                <h1 id="SignUp">Sign up</h1>
            </div>
            <div class="container">
                <form id="signinForm">
                    <input type="text" name="username" placeholder="Username">
                    <input type="password" name="password" placeholder="Password"><span class="fa-solid fa-eye"></span>
                    <input type="submit" name="submit" value="Login">
                </form>
            </div>
        </div>
        <div class="option">
            <p>Don't have an account? <a href="./sign_up.php">Sign-up now</a></p>
        </div>
    </main>
</body>
<script src="js/login.js" type="module"></script>

</html>