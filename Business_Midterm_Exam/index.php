<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php'; 

if(!isset($_SESSION['designerID']) || !isset($_SESSION['username'])) {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Activity</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Welcome <?php echo getDesignerByID($pdo, $_SESSION['designerID'])['firstName'] ?> to Seed's Designer/Artist Management System!</h2>

    <input type="submit" value="Log out" onclick="window.location.href='core/logout.php'">
    <input type="submit" value="Designer Logs" onclick="window.location.href='designerlogs.php'">

    <h3>Here are your Designs!</h3>
        <table>
            <tr>
                <th>Designer ID</th>
                <th>Design Name</th>
                <th>Fabric Type</th>
                <th>Price</th>
                <th>Date Added</th>
                <th>Action</th>
            </tr>
            
            <?php $getDesignByDesignerID = getDesignsByDesigners($pdo, $_SESSION['designerID']); ?>
            <?php foreach ($getDesignByDesignerID as $row) { ?>
            <tr>
                <td><?php echo $row['designID']?></td>
                <td><?php echo $row['designName']?></td>
                <td><?php echo $row['fabricType']?></td>
                <td><?php echo $row['price']?></td>
                <td><?php echo $row['date_added']?></td>
                <td>
                    <?php
                        $designID = $row['designID'];
                        $designerID = $_SESSION['designerID'];
                    ?>
                    <input type="submit" value="Edit Design" onclick="window.location.href='editdesigns.php?designID=<?php echo $designID; ?>&designerID=<?php echo $designerID; ?>';">
                    <input type="submit" value="Remove Design" onclick="window.location.href='deletedesigns.php?designID=<?php echo $designID; ?>&designerID=<?php echo $designerID; ?>';">
                </td>
            </tr>
            <?php } ?>
        </table> <br>

        <input type="submit" value="Add Design" onclick="window.location.href='viewdesigns.php?designerID=<?php echo $_SESSION['designerID']; ?>';">

        <br><br><br>
        <h3>Your profile</h3>
        <table>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Address</th>
                <th>Age</th>
                <th>Specialization</th>
                <th>Email Address</th>
                <th>Date Added</th>
            </tr>

            <?php $userData = getDesignerByID($pdo, $_SESSION['designerID']); ?>
            <tr>
                <td><?php echo $userData['designerID']?></td>
                <td><?php echo $userData['firstName']?></td>
                <td><?php echo $userData['lastName']?></td>
                <td><?php echo $userData['d_address']?></td>
                <td><?php echo $userData['age']?></td>
                <td><?php echo $userData['specialization']?></td>
                <td><?php echo $userData['e_address']?></td>
                <td><?php echo $userData['date_added']?></td>
            </tr>
        </table>

        <input type="submit" value="Edit Profile" onclick="window.location.href='editdesigners.php?designerID=<?php echo $userData['designerID']; ?>';">
        <input type="submit" value="Delete Account" onclick="window.location.href='deletedesigners.php?designerID=<?php echo $userData['designerID']; ?>';">
    </body>
</html>