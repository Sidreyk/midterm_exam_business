<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seed's Designer/Artist Management System</title>
    <link rel="stylesheet" href="style.css" <?php echo time(); ?>"">
    <style>
        h2 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
        h3 {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
        }
    </style>
</head>
<body>
    <h3>Welcome to Seed's Designer/Artist Management System!</h3>
    <h2>Register your account below!</h2>

    <?php if (isset($_SESSION['message'])) { ?>
		    <h1 style="color: red;"><?php echo $_SESSION['message']; ?></h1>
	    <?php } unset($_SESSION['message']); ?>

    <form action="core/handleForms.php" method="POST">
        <p>
        <label for="username">Username</label>
        <input type="text" name="username" required>
        </p>
        <p>
        <label for="user_password">Password</label>
        <input type="password" name="user_password" required>
        </p>
        <p>
        <label for="confirm_password">Confirm password</label>
        <input type="password" name="confirm_password" required>
        </p>
        <p>
            <label for="firstName">First Name: </label>
            <input type="text" name="firstName" required>
        </p>
        <p>
            <label for="lastName">Last Name: </label>
            <input type="text" name="lastName" required>
        </p>
        <p>
            <label for="d_address">Address: </label>
            <input type="text" name="d_address" required>
        </p>
        <p>
            <label for="age">Age: </label>
            <input type="number" name="age" min="1" required>
        </p>
        <p>
            <label for="specialization">Choose a designer specialization:</label>
            <select id="specialization" name="specialization">
                <option value="Streetwear Designer">Streetwear Designer</option>
                <option value="Sustainable Fashion Designer">Sustainable Fashion Designer</option>
                <option value="Luxury Fashion Designer">Luxury Fashion Designer</option>
                <option value="Athleisure Designer">Athleisure Designer</option>
                <option value="Denimwear Designer">Denimwear Designer</option>
            </select>
        </p>
        <p>
            <label for="e_address">Email Address: </label>
            <input type="text" name="e_address" required>
        </p>
        <p>
            <input type="submit" name="registerBtn" value="Register Account">
        </p>
        <p>
            <input type="submit" name="returnButton" value="Return to Login Page" onclick="window.location.href='login.php'">
        </p>
    </form>
</body>
</html>