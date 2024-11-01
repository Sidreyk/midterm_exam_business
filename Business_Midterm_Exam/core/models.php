<?php

// Function to insert a designer
function insertDesigner($pdo, $firstName, $lastName, $d_address, $age, $specialization, $e_address) {
    $sql = "INSERT INTO designers_info (firstName, lastName, d_address, age, specialization, e_address) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$firstName, $lastName, $d_address, $age, $specialization, $e_address]);
    return $executeQuery;
}

// Function to update a designer
function updateDesigner($pdo, $firstName, $lastName, $d_address, $age, $specialization, $e_address, $designerID) {
    $sql = "UPDATE designers_info
            SET firstName = ?, lastName = ?, d_address = ?, age = ?, specialization = ?, e_address = ?
            WHERE designerID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$firstName, $lastName, $d_address, $age, $specialization, $e_address, $designerID]);
    return $executeQuery;
}

function deleteDesigner($pdo, $designerID) {
    $query1 = "DELETE FROM designs WHERE designID = ?";
    $statement1 = $pdo -> prepare($query1);
    $executeQuery1 = $statement1 -> execute(['designID']);

    if($executeQuery1) {
        $query2 = "DELETE FROM designers_info WHERE designerID = ?";
        $statement2 = $pdo -> prepare($query2);
        $executeQuery2 = $statement2 -> execute([$designerID]);

        $query3 = "DELETE FROM designer_account WHERE userID = ?";
        $statement3 = $pdo -> prepare($query3);
        $executeQuery3 = $statement3 -> execute([$designerID]);

        if($executeQuery2 && $executeQuery2) {
            return true;
        }
    }
}

// Function to get all designers
function getAllDesigners($pdo) {
    $sql = "SELECT * FROM designers_info";
    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute();
    
    if ($success) {
        return $stmt->fetchAll();
    } else {
        return false;
    }
}


// Function to get a designer by ID
function getDesignerByID($pdo, $designerID) {
    $sql = "SELECT * FROM designers_info WHERE designerID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$designerID]);
    return $stmt->fetch();
}

// Function to get designs by designer ID
function getDesignsByDesigners($pdo, $designerID) {
    $sql = "SELECT designs.designID, designs.designName, designs.fabricType, designs.price, designs.date_added,
                   CONCAT(designers_info.firstName, ' ', designers_info.lastName) AS Designer_Owner
            FROM designs
            JOIN designers_info ON designs.designerID = designers_info.designerID
            WHERE designs.designerID = ?
            ORDER BY designs.designName";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$designerID]);
    return $stmt->fetchAll();
}

// Function to insert a new design
function insertDesigns($pdo, $designName, $fabricType, $price, $designerID) {
    $sql = "INSERT INTO designs (designName, fabricType, price, designerID) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$designName, $fabricType, $price, $designerID]);

    if($executeQuery) {
        $designID = getNewestDesignID($pdo)['designID'];
        $designData = getDesignByID($pdo, $designID);
        logDesignerAction($pdo, "ADDED", $designData['designerID'], $designID, $_SESSION['designerID']);
        return true;
    }
}

// Function to get a design by ID
function getDesignByID($pdo, $designID) {
    $sql = "SELECT designs.designerID, designs.designID, designs.designName, designs.fabricType, designs.price, designs.date_added,
                   CONCAT(designers_info.firstName, ' ', designers_info.lastName) AS Designer_Owner
            FROM designs
            JOIN designers_info ON designs.designerID = designers_info.designerID
            WHERE designs.designID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$designID]);
    return $stmt->fetch();
}

// Function to update a design
function updateDesign($pdo, $designName, $fabricType, $price, $designID) {
    $designData = getDesignByID($pdo, $designID);

    $sql = "UPDATE designs
            SET designName = ?, fabricType = ?, price = ?
            WHERE designID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$designName, $fabricType, $price, $designID]);

    if($executeQuery) {
        logDesignerAction($pdo, "UPDATED", $designData['designerID'], $designID, $_SESSION['designerID']);
        return true;
    }
}

// Function to delete a design
function deleteDesign($pdo, $designID) {
    $designData = getDesignByID($pdo, $designID);
    

    $sql = "DELETE FROM designs WHERE designID = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$designID]);

    if($executeQuery) {
        logDesignerAction($pdo, "REMOVED", $designData['designerID'], $designID, $_SESSION['designerID']);
        return true;
    }
}


function loginUser ($pdo, $username, $user_password) {
    $sql = "SELECT * FROM designer_account WHERE username=?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $usernameFromDB = $userInfoRow['username'];
        $passwordFromDB = $userInfoRow['user_password'];

        if (password_verify($user_password, $passwordFromDB)) {
            $_SESSION['designerID'] = $userInfoRow['userID']; // Ensure this is consistent with your index.php
            $_SESSION['username'] = $usernameFromDB;
            $_SESSION['message'] = "Login successful!";
            return 'loginSuccess';
        } else {
            $_SESSION['message'] = "Password is incorrect!";
            return 'incorrectPassword';
        }
    } else {
        $_SESSION['message'] = "Username doesn't exist from the database. You may consider registration first.";
        return 'usernameDoesNotExist';
    }
}

function checkUsernameExistence($pdo, $username) {
	$query = "SELECT * FROM designer_account WHERE username = ?";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$username]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function checkUserExistence($pdo, $firstName, $lastName, $d_address, $age, $specialization, $e_address) {
	$query = "SELECT * FROM designers_info
				WHERE firstName = ? AND 
				lastName = ? AND
				d_address = ? AND
				age = ? AND
				specialization = ? AND
                e_address = ? ";
	$statement = $pdo -> prepare($query);
	$executeQuery = $statement -> execute([$firstName, $lastName, $d_address, $age, $specialization, $e_address]);

	if($statement -> rowCount() > 0) {
		return true;
	}
}

function validatePassword($user_password) {
	if(strlen($user_password) >= 8) {
		$hasLower = false;
		$hasUpper = false;
		$hasNumber = false;

		for($i = 0; $i < strlen($user_password); $i++) {
			if(ctype_lower($user_password[$i])) {
				$hasLower = true;
			}
			if(ctype_upper($user_password[$i])) {
				$hasUpper = true;
			}
			if(ctype_digit($user_password[$i])) {
				$hasNumber = true;
			}

			if($hasLower && $hasUpper && $hasNumber) {
				return true;
			}
		}
	}
	return false;
}

function sanitizeInput($input) {
	$input = trim($input);
	$input = stripslashes($input);
	$input = htmlspecialchars($input);
	return $input;
}

function registerUser($pdo, $username, $user_password, $hashed_password, $confirm_password, $firstName, $lastName, $d_address, $age, $specialization, $e_address) {
    if (checkUsernameExistence($pdo, $username)) {
        return "UsernameAlreadyExists";
    }
    if($user_password != $confirm_password) {
        return "PasswordNotMatch";
    }
    if (!validatePassword($user_password)) {
        return "InvalidPassword";
    }

    $query1 = "INSERT INTO designer_account (username, user_password) VALUES (?, ?)";
    $statement1 = $pdo -> prepare($query1);
    $executeQuery1 = $statement1 -> execute([$username, $hashed_password]);

    $query2 = "INSERT INTO designers_info (firstName, lastName, d_address, age, specialization, e_address) VALUES (?, ?, ?, ?, ?, ?)";
    $statement2 = $pdo -> prepare($query2);
    $executeQuery2 = $statement2 -> execute([$firstName, $lastName, $d_address, $age, $specialization, $e_address]);

    if ($executeQuery1 && $executeQuery2) {
        return "registrationSuccess";
    }
}

function getDesignerLogs ($pdo) {
    $query = "SELECT * FROM designer_logs ORDER BY dateLogged DESC";
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute();

    if($executeQuery) {
        return $statement -> fetchAll();
    }
}

function logDesignerAction($pdo, $logsDescription, $designerID, $designID, $doneBy){
    $query = "INSERT INTO designer_logs (logsDescription, designerID, designID, doneBy) VALUES (?,?,?,?)";
    $statement = $pdo -> prepare($query);
    $executeQuery = $statement -> execute([$logsDescription, $designerID, $designID, $doneBy]);

    if($executeQuery){
        return true;
    }
}

function getNewestDesignID($pdo) {
	$query = "SELECT designID
			FROM designs
			ORDER BY designID DESC
    		LIMIT 1;";
		$statement = $pdo -> prepare($query);
		$executeQuery = $statement -> execute();
		
		if ($executeQuery) {
			return $statement -> fetch();
		}
}

function redirectWithMessage($location, $message) {
    $_SESSION['message'] = $message;
    header("Location: $location");
    exit();
}
?>
