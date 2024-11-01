<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
    <?php $getDesignsByID = getDesignByID($pdo, $_GET['designID']); ?>
    <h1>Are you sure you want to delete this Design?</h1>

    <table>
        <tr>
            <th>Design Name</th>
            <td><?php echo $getDesignsByID['designID']; ?></td>
        </tr>
        <tr>
            <th>Fabric Type</th>
            <td><?php echo $getDesignsByID['fabricType']; ?></td>
        </tr>
        <tr>
            <th>Price</th>
            <td><?php echo $getDesignsByID['price']; ?></td>
        </tr>
        <tr>
            <th>Date Added</th>
            <td><?php echo $getDesignsByID['date_added']; ?></td>
        </tr>
    </table>

    <form action="core/handleForms.php?designID=<?php echo $_GET['designID']; ?>&designerID=<?php echo $_GET['designerID']; ?>" method="POST">
        <input type="submit" name="deleteDesignBtn" value="Delete">
    </form>

    <p><a href="viewdesigns.php?designerID=<?php echo $_GET['designerID']; ?>">Cancel</a></p>
</body>
</html>