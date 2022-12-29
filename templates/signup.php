<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.0.js"></script>
    <script type="text/javascript" src="js/signup.js"></script>
</head>

<body>
    <main>
        <div class="page">
            <div class="header">
                <h1 id="SignUp">Sign up</h1>
            </div>
            <div class="container">

                <i class="fa-solid fa-asterisk"></i><input type="text" name="username" id="username" placeholder="username" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="password" name="password1" id="password1" placeholder="password" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="password" name="password2" id="password2" placeholder="confirm password" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="text" name="name" id="name" placeholder="name" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="text" name="surname" id="surname" placeholder="surname" required><br>
                <input type="text" name="email" id="email" placeholder="email"><br>
                <input type="text" name="phone" id="phone" placeholder="phone"><br>
                <label for="birthday">birthday:</label>&nbsp;
                <input type="date" id="birthdate" name="birthdate"><i class="fa-regular fa-calendar"></i><br><br>
                <button type="button" onclick="submitForm(document.getElementById('username').value, document.getElementById('password1').value, 
                document.getElementById('password2').value, document.getElementById('name').value, document.getElementById('surname').value, 
                document.getElementById('email').value, document.getElementById('phone').value, document.getElementById('birthdate').value)">Sign up</button>

            </div>
        </div>
        <div class="option">
            <p>Already have an account? <a href="">Login now</a></p>
        </div>
    </main>
</body>

</html>