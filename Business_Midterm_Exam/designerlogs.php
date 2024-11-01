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
    <title>Seed's Designer/Artist Management System</title>
    <link rel="stylesheet" href="style.css?v=<?php echo time(); ?>">
</head>
    <body>
        <h2>Designer Logs</h2>

        <input type="submit" value="Return To Your Profile" onclick="window.location.href='index.php'">

        <table>
            <tr>
                <th>Log ID</th>
                <th>Action Done</th>
                <th>Designer ID</th>
                <th>Design ID</th>
                <th>Done By</th>
                <th>Date Logged</th>
            </tr>

            <?php $DesignerLogs = getDesignerLogs($pdo); ?>
            <?php foreach ($DesignerLogs as $row) { ?>
            <tr>
                <td><?php echo $row['logs_id']?></td>
                <td><?php echo $row['logsDescription']?></td>
                <td><?php echo $row['designerID']?></td>
                <td><?php echo $row['designID']?></td>
                <td><?php echo $row['doneBy']?></td>
                <td><?php echo $row['dateLogged']?></td>
            </tr>
            <?php } ?>
        </table>    
    </body>
</html>

