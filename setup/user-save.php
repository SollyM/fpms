<?php
require "../inc/config.inc.php";
require "../classes/classes.php";

try {
    
    $db = new DbConn;
    $err = '';
    
    $userId = $_POST["userId"];
    $username = $_POST["username"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $jobTitle = $_POST["jobTitle"];
    $emailAddress = $_POST["emailAddress"];
    $roleId = $_POST["roleId"];
    $engagedDate = $_POST["engagedDate"];
    $verified = $_POST["verified"];
    $userPassword1 = $_POST["userPassword1"];
    $userPassword2 = $_POST["userPassword2"];

    if ($userPassword1 != "" && $userPassword1 == $userPassword2) {
        $newPassword = password_hash($userPassword1, PASSWORD_DEFAULT);
    }
    else {
        $newPassword  = "";
    }

    $qryCheck = "SELECT * FROM tblusers WHERE username = :username";
    $qryUpdate = "UPDATE tblusers SET FirstName = :firstName, LastName = :lastName, JobTitle = :jobTitle, Email = :emailAddress, RoleId = :roleId, DateEngaged = :engagedDate, verified = :verified, username = :username WHERE id = :userid";
    $qryInsert = "INSERT INTO tblusers (id, username, FirstName, LastName, JobTitle, Email, RoleId, DateEngaged, verified) VALUES (:userId, :username, :firstName, :lastName, :jobTitle, :emailAddress, :roleId, :engagedDate, :verified)";

    $stmt_check = $db->conn->prepare($qryCheck);
    $stmt_check->bindParam(':username', $username);
    $stmt_check->execute();
    $result = $stmt_check->fetch();

    if ($result["id"] != null) { //found the user
        if ($result["id"] == $userId) { //edit
            $stmt = $db->conn->prepare($qryUpdate);
            $stmt->bindParam(':firstName',$firstName);
            $stmt->bindParam(':lastName',$lastName);
            $stmt->bindParam(':jobTitle',$jobTitle);
            $stmt->bindParam(':emailAddress',$emailAddress);
            $stmt->bindParam(':roleId',$roleId);
            $stmt->bindParam(':engagedDate',$engagedDate);
            $stmt->bindParam(':verified',$verified);
            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':userid',$userId);
            $stmt->execute();

            if ($newPassword != "") {
                $stmt = $db->conn->prepare("UPDATE tblusers SET Password = :password WHERE id = :userid");
                $stmt->bindParam(':password',$newPassword);
                $stmt->bindParam(':userid',$userId);
                $stmt->execute();
            }
        }
        else {
            $err = "Username already in use.<br>";
            echo $err;
        }
    }
    else { //add
        $userId = uniqid(rand(), false);

        $stmt = $db->conn->prepare($qryInsert);
        $stmt->bindParam(':userId',$userId);
        $stmt->bindParam(':username',$username);
        $stmt->bindParam(':firstName',$firstName);
        $stmt->bindParam(':lastName',$lastName);
        $stmt->bindParam(':jobTitle',$jobTitle);
        $stmt->bindParam(':emailAddress',$emailAddress);
        $stmt->bindParam(':roleId',$roleId);
        $stmt->bindParam(':engagedDate',$engagedDate);
        $stmt->bindParam(':verified',$verified);
        $stmt->execute();

        if ($newPassword != "") {
            $stmt = $db->conn->prepare("UPDATE tblusers SET Password = :password WHERE id = :userid");
            $stmt->bindParam(':password',$newPassword);
            $stmt->bindParam(':userid',$userId);
            $stmt->execute();
        }
    }

    $_SESSION["Saved"] = "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Saved Successfully.</div>";
    header("location:user-details.php?uid=". $userId ."&mode=view");
} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    echo $err;
}
?>