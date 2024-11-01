<?php require_once 'core/handleForms.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designer</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php 
    $getDesignerByID = getDesignerByID($pdo, $_GET['designerID']);
    
    if (!$getDesignerByID) {
        echo "<h2>Designer not found!</h2>";
        exit;
    }
    ?>
    
    <h1>Edit the Designer!</h1>
    <form action="core/handleForms.php?designerID=<?php echo $_GET['designerID']; ?>" method="POST">
        <p>
            <label for="firstName">First Name: </label>
            <input type="text" name="firstName" value="<?php echo $getDesignerByID['firstName']; ?>" required>
        </p>
        <p>
            <label for="lastName">Last Name: </label>
            <input type="text" name="lastName" value="<?php echo $getDesignerByID['lastName']; ?>" required>
        </p>
        <p>
            <label for="d_address">Address: </label>
            <input type="text" name="d_address" value="<?php echo $getDesignerByID['d_address']; ?>" required>
        </p>
        <p>
            <label for="age">Age: </label>
            <input type="number" name="age" min="1" value="<?php echo $getDesignerByID['age']; ?>" required>
        </p>
        <label for="specialization">Choose a designer specialization:</label>
                <select id="specialization" name="specialization">
                    <option value="Streetwear Designer">Streetwear Designer</option>
                    <option value="Sustainable Fashion Designer">Sustainable Fashion Designer</option>
                    <option value="Luxury Fashion Designer">Luxury Fashion Designer</option>
                    <option value="Athleisure Designer">Athleisure Designer</option>
                    <option value="Denimwear Designer">Denimwear Designer</option>
                </select>
        <p>
            <label for="e_address">Email Address: </label>
            <input type="text" name="e_address" value="<?php echo $getDesignerByID['e_address']; ?>" required>
        </p>
        <p><input type="submit" name="editDesignerBtn" value="Update Designer"></p>
    </form>
    
    <p><a href="index.php">Return to Home Screen</a></p>
</body>
</html>