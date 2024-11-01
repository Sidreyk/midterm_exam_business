<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Designs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Edit the Designs!</h1>
    
    <p><a href="viewdesigns.php?designerID=<?php echo $_GET['designerID']; ?>">View the Designs</a></p>
    
    <?php 
    if (isset($_GET['designID'])) {
        $getDesignByID = getDesignByID($pdo, $_GET['designID']);
        
        if ($getDesignByID) { 
    ?>
        <form action="core/handleForms.php?designID=<?php echo $_GET['designID']; ?>&designerID=<?php echo $_GET['designerID']; ?>" method="POST">
            <div>
                <label for="designName">Design Name</label>
                <input type="text" name="designName" value="<?php echo htmlspecialchars($getDesignByID['designName']); ?>" required>
            </div>
            <div>
                <label for="fabricType">Choose a fabric type:</label>
                <select id="fabricType" name="fabricType" required>
                    <option value="cotton" <?php echo ($getDesignByID['fabricType'] == 'cotton') ? 'selected' : ''; ?>>Cotton</option>
                    <option value="polyester" <?php echo ($getDesignByID['fabricType'] == 'polyester') ? 'selected' : ''; ?>>Polyester</option>
                    <option value="linen" <?php echo ($getDesignByID['fabricType'] == 'linen') ? 'selected' : ''; ?>>Linen</option>
                    <option value="rayon" <?php echo ($getDesignByID['fabricType'] == 'rayon') ? 'selected' : ''; ?>>Rayon</option>
                    <option value="denim" <?php echo ($getDesignByID['fabricType'] == 'denim') ? 'selected' : ''; ?>>Denim</option>
                </select>
            </div>
            <div>
                <label for="price">Price</label>
                <input type="number" name="price" step="0.01" min="1" value="<?php echo htmlspecialchars($getDesignByID['price']); ?>" required>
            </div>
            <div>
                <input type="submit" name="editDesignBtn" value="Update Design">
            </div>
        </form>
    <?php 
        } else {
            echo "<p>Design not found.</p>";
        }
    } else {
        echo "<p>No design ID provided.</p>";
    }
    ?>
    
    <p><a href="viewdesigns.php?designerID=<?php echo $_GET['designerID']; ?>">Return to Designs</a></p>
</body>
</html>