<?php 
require_once 'core/dbConfig.php'; 
require_once 'core/models.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Designer</title>
    <link rel="stylesheet" href="style.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Are you sure you want to delete this designer?</h1>
    
    <?php 
    if (isset($_GET['designerID'])) {
        $getDesignerByID = getDesignerByID($pdo, $_GET['designerID']); 
        
        if ($getDesignerByID) {
            ?>
            <table>
                <tr>
                    <th>First Name</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['firstName']); ?></td>
                </tr>
                <tr>
                    <th>Last Name</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['lastName']); ?></td>
                </tr>
                <tr>
                    <th>Age</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['age']); ?></td>
                </tr>
                <tr>
                    <th>Address</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['d_address']); ?></td>
                </tr>
                <tr>
                    <th>Specialization</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['specialization']); ?></td>
                </tr>
                <tr>
                    <th>Email Address</th>
                    <td><?php echo htmlspecialchars($getDesignerByID['e_address']); ?></td>
                </tr>
            </table>

            <form action="core/handleForms.php?designerID=<?php echo urlencode($_GET['designerID']); ?>" method="POST">
                <input type="submit" name="deleteDesignerBtn" value="Delete">
            </form>
            
            <p><a href="index.php?designerID=<?php echo $_GET['designerID']; ?>">Cancel</a></p>
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