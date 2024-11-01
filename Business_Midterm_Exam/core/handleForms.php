<?php
require_once 'dbConfig.php';
require_once 'models.php';

// Insert a new designer
if (isset($_POST['insertDesignerBtn'])) {
    $query = insertDesigner($pdo, $_POST['firstName'], $_POST['lastName'], $_POST['d_address'], $_POST['age'], $_POST['specialization'], $_POST['e_address']);
    if ($query) {
        header("Location: ../index.php");
        exit();
    } else {
        echo "Insertion Failed";
    }
}

// Edit an existing designer
if (isset($_POST['editDesignerBtn'])) {
    $query = updateDesigner($pdo, $_POST['firstName'], $_POST['lastName'], $_POST['d_address'], $_POST['age'], $_POST['specialization'], $_POST['e_address'], $_GET['designerID']);
    if ($query) {
        header("Location: ../index.php");
        exit(); 
    } else {
        echo "Edit Failed";
    }
}

// Delete a designer
if (isset($_POST['deleteDesignerBtn'])) {
    $query = deleteDesigner($pdo, $_GET['designerID']);
    if ($query) {
        header("Location: ../login.php");
        exit();
    } else {
        echo "Deletion Failed";
    }
}

// Insert a new design
if (isset($_POST['insertNewDesignBtn'])) {
    $query = insertDesigns($pdo, $_POST['designName'], $_POST['fabricType'], $_POST['price'], $_GET['designerID']);
    if ($query) {
        header("Location: ../viewdesigns.php?designerID=" . $_GET['designerID']);
        exit(); 
    } else {
        echo "Insertion Failed";
    }
}

// Edit an existing design
if (isset($_POST['editDesignBtn'])) {
    if (isset($_GET['designID'])) {
        $query = updateDesign($pdo, $_POST['designName'], $_POST['fabricType'], $_POST['price'], $_GET['designID']);
        if ($query) {
            header("Location: ../viewdesigns.php?designerID=" . $_GET['designerID']);
            exit(); 
        } else {
            echo "Update Failed";
        }
    } else {
        echo "No design ID provided.";
    }
}

// Delete a design
if (isset($_POST['deleteDesignBtn'])) {
    $query = deleteDesign($pdo, $_GET['designID']);
    if ($query) {
        header("Location: ../viewdesigns.php?designerID=" . $_GET['designerID']);
        exit(); 
    } else {
        echo "Deletion Failed";
    }
}

if (isset($_POST['loginBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];

    // Call the login function from models
    $loginStatus = loginUser($pdo, $username, $user_password);

    switch ($loginStatus) {
        case "loginSuccess":
            redirectWithMessage('../index.php', '');
            break;
        case "usernameDoesNotExist":
            redirectWithMessage('../login.php', 'Username does not exist!');
            break;
        case "incorrectPassword":
            header("Location: ../login.php");
            exit(); // Prevent further execution
        default:
            redirectWithMessage('../login.php', 'An unexpected error occurred.');
            break;
    }
}

if(isset($_POST['registerBtn'])) {
    $username = sanitizeInput($_POST['username']);
    $user_password = $_POST['user_password'];
    $hashed_password = password_hash($_POST['user_password'], PASSWORD_DEFAULT);
    $confirm_password = sanitizeInput($_POST['confirm_password']);
    $firstName = sanitizeInput($_POST['firstName']);
    $lastName = sanitizeInput($_POST['lastName']);
    $d_address = $_POST['d_address'];
    $age = $_POST['age'];
    $specialization = $_POST['specialization'];
    $e_address = sanitizeInput($_POST['e_address']);

    $function = registerUser($pdo, $username, $user_password, $hashed_password, $confirm_password, $firstName, $lastName, $d_address, $age, $specialization, $e_address);
    if($function == "registrationSuccess") {
        header("Location: ../login.php");
    } elseif($function == "UsernameAlreadyExists") {
        $_SESSION['message'] = "Username already exists! Please choose a different username!";
        header("Location: ../register.php");
    } elseif($function == "UserAlreadyExists") {
        $_SESSION['message'] = "User already exists! Please edit your existing account instead!";
        header("Location: ../register.php");
    } elseif($function == "PasswordNotMatch") {
        $_SESSION['message'] = "Password does not match!";
        header("Location: ../register.php");
    } elseif($function == "InvalidPassword") {
        $_SESSION['message'] = "Password is not strong enough! Make sure it is 8 letters long, has uppercase and lowercase characters, and numbers.";
        header("Location: ../register.php");
    } else {
        echo "<h2>User addition failed.</h2>";
        echo '<a href="../register.php">';
        echo '<input type="submit" id="returnHomeButton" value="Return to register page" style="padding: 6px 8px; margin: 8px 2px;">';
        echo '</a>';
    } 
}

?>
