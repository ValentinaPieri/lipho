<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <div class="page">
            <div class="header">
                <h1 id="Login">Login</h1>
            </div>
            <div class="container">
                <form id="loginForm">
                    <input title="username" aria-label="username" type="text" name="username" id="username" placeholder="Username" />
                    <input title="password" aria-label="password" type="password" name="password" id="password" placeholder="Password" /><span id="visible" class="fa-solid fa-eye"></span>
                    <input title="login button" aria-label="button to login" type="submit" id="loginButton" value="Login" />
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
