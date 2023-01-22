<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="icon" type="image/x-icon" href="resources/icons/favicon.ico">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Noto Sans'>
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <main>
        <div class="page">
            <div class="header">
                <h1 id="Login">Login</h1>
            </div>
            <div class="containerForm">
                <form id="loginForm">
                    <input title="username" aria-label="username" type="text" name="username" id="username" placeholder="Username" />
                    <div class="input-field">
                        <input title="password" aria-label="password" type="password" name="password" id="password" placeholder="Password" />
                        <button id="visible" class="icon-button">
                            <span class="fa-solid fa-eye"></span>
                        </button>
                    </div>
                    <input title="login button" class="login-button" aria-label="button to login" type="submit" id="loginButton" value="Login" />
                </form>
            </div>
            <div class="option">
                <p>Don't have an account? <a href="./signup.php">Sign-up now</a></p>
            </div>
        </div>
    </main>
</body>
<script src="js/login.js" type="module"></script>

</html>
