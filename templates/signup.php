<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lipho | <?php echo $templateParams["title"]; ?></title>
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.2.1/css/all.css">
</head>

<main>
    <div class="page">
        <div class="header">
            <h1 id="SignUp">Sign up</h1>
        </div>
        <div class="container">
            <form action="" method="post" target="_blank">
                <i class="fa-solid fa-asterisk"></i><input type="text" name="username" placeholder="username" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="password" name="password1" placeholder="password" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="password" name="password2"
                    placeholder="confirm password" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="text" name="name" placeholder="name" required><br>
                <i class="fa-solid fa-asterisk"></i><input type="text" name="surname" placeholder="surname" required><br>
                <input type="text" name="email" placeholder="email"><br>
                <input type="text" name="phone" placeholder="phone"><br>
                <label for="birthday">birthday:</label>&nbsp;
                <input type="date" id="birthday" name="birthday"><i class="fa-regular fa-calendar"></i><br><br>
                <button type="submit" name="sign-up">Sign up</button>
            </form>
        </div>
    </div>
    <div class="option">
        <p>Already have an account? <a href="">Login now</a></p>
    </div>
</main>

</html>