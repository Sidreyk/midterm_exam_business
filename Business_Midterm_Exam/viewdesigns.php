<?php 
require_once 'core/models.php'; 
require_once 'core/dbConfig.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Designs</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <p><a href="index.php">Return to Home Screen</a></p>

    <?php 
    if (isset($_GET['designerID'])) {
        // Fetch designer info by ID
        $getAllInfoByDesignerID = getDesignerByID($pdo, $_GET['designerID']);
        
        if ($getAllInfoByDesignerID) {
    ?>
            <h1>Designer ID: <?php echo htmlspecialchars($getAllInfoByDesignerID['designerID']); ?></h1>

            <h2>Add New Designs</h2>
            <form action="core/handleForms.php?designerID=<?php echo $_GET['designerID']; ?>" method="POST">
                <div>
                    <label for="designName">Design Name:</label>
                    <input type="text" name="designName" required>
                </div>
                <div>
                    <label for="fabricType">Choose a fabric type:</label>
                    <select id="fabricType" name="fabricType" required>
                        <option value="cotton">Cotton</option>
                        <option value="polyester">Polyester</option>
                        <option value="linen">Linen</option>
                        <option value="rayon">Rayon</option>
                        <option value="denim">Denim</option>
                    </select>
                </div>
                <div>
                    <label for="price">Price:</label>
                    <input type="number" name="price" step="0.01" min="1" required>
                </div>
                <div>
                    <input type="submit" name="insertNewDesignBtn" value="Add Design">
                </div>
            </form>

            <h2>Current Designs</h2>
            <table class="designer-table">
                <thead>
                    <tr>
                        <th>Design ID</th>
                        <th>Design Name</th>
                        <th>Fabric Type</th>
                        <th>Price</th>
                        <th>Date Added</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $getDesignsByDesigner = getDesignsByDesigners($pdo, $_GET['designerID']); 
                    foreach ($getDesignsByDesigner as $row) { 
                    ?>
                        <tr>
                            <td><?php echo ($row['designID']); ?></td>
                            <td><?php echo ($row['designName']); ?></td>
                            <td><?php echo ($row['fabricType']); ?></td>
                            <td><?php echo ($row['price']); ?></td>
                            <td><?php echo ($row['date_added']); ?></td>
                            <td>
                                <a href="editdesigns.php?designID=<?php echo $row['designID']; ?>&designerID=<?php echo $_GET['designerID']; ?>">Edit</a>
                                <a href="deletedesigns.php?designID=<?php echo $row['designID']; ?>&designerID=<?php echo $_GET['designerID']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
    <?php 
        } else {
            echo "<h2>Designer not found.</h2>";
        }
    } else {
        echo "<h2>No designer ID provided.</h2>";
    }
    ?>
</body>
</html>