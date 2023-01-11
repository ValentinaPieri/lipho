<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script src="js/signup.js"></script>
</head>

<body>
    <main>
        <div class="page">
            <div class="header">
                <h1 id="SignUp">Sign up</h1>
            </div>
            <div class="container">
                <form id="signupForm">
                    <span class="fa-solid fa-asterisk"></span><input title="username" aria-label="username input form" type="text" name="username" id="username" placeholder="username">
                    <span class="fa-solid fa-asterisk"></span><input title="password" aria-label="password input form" type="password" name="password1" id="password1" placeholder="password">
                    <span class="fa-solid fa-asterisk"></span><input title="confirm password" aria-label="confirm password input form" type="password" name="password2" id="password2" placeholder="confirm password">
                    <span class="fa-solid fa-asterisk"></span><input title="name" aria-label="name input form" type="text" name="name" id="name" placeholder="name">
                    <span class="fa-solid fa-asterisk"></span><input title="surname" aria-label="surname input form" type="text" name="surname" id="surname" placeholder="surname">
                    <input title="email" aria-label="email input form" type="text" name="email" id="email" placeholder="email">
                    <input title="phone" aria-label="phone input form" type="tel" name="phone" id="phone" placeholder="ex. +393213334444">
                    <label for="birthdate">birthday:</label>
                    <input title="birthdate" type="date" id="birthdate" name="birthdate"><span class="fa-regular fa-calendar"></span>
                    <input aria-label="button to submit" type="submit" id="signupButton" value="Sign Up">
                </form>
            </div>
        </div>
        <div class="option">
            <p>Already have an account? <a href="">Login now</a></p>
        </div>
    </main>
</body>

</html>