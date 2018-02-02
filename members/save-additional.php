<?php
include_once "../inc/sessions.php";
require "../inc/config.inc.php";
require "../classes/classes.php";

$polid = $_POST["policyId"];
$personId = $_POST["additionalPersonId"];
$personTypeId = $_POST["additionalPersonType"];

try {
    
    $db = new DbConn;
    $err = '';
    
 } catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
    
 }

//---   Policy Holder Information   ---//
if ($_POST["additionalFirstName"] != null && $_POST["additionalLastName"] != null) {
    AddPerson($polid, $personId, $personTypeId);
}

function AddPerson($polid, $personId, $personTypeId) {
    $db = new DbConn;
    $userId = $_SESSION["UserId"];

    $stmt_per_add   =  "INSERT INTO tblpersons
                        (FirstName, MiddleNames, LastName, TitleId, IDNumber, DateOfBirth, HomePhone, WorkPhone, MobilePhone, HomeEmail, WorkEmail)
                        VALUES
                        (:firstname, :middlenames, :lastname, :titleid, :idnumber, :birthdate, :homephone, :workphone, :mobilephone, :homeemail, :workemail)";
    $stmt_per_edit  =  "UPDATE tblpersons
                        JOIN lnkpersonpolicies ON  lnkpersonpolicies.PersonId = tblpersons.PersonId
                        SET tblpersons.FirstName    = :firstname,
                            tblpersons.MiddleNames  = :middlenames,
                            tblpersons.LastName     = :lastname,
                            tblpersons.TitleId      = :titleid,
                            tblpersons.IDNumber     = :idnumber,
                            tblpersons.DateOfBirth  = :birthdate,
                            tblpersons.HomePhone    = :homephone,
                            tblpersons.WorkPhone    = :workphone,
                            tblpersons.MobilePhone  = :mobilephone,
                            tblpersons.HomeEmail    = :homeemail,
                            tblpersons.WorkEmail    = :workemail
                        WHERE lnkpersonpolicies.PersonId = :personid AND lnkpersonpolicies.PolicyId = :policyid";

    $firstname = $_POST["additionalFirstName"];
    $middlenames = $_POST["additionalMiddleNames"];
    $lastname = $_POST["additionalLastName"];
    $titleid = $_POST["additionalTitle"];
    $idnumber = $_POST["additionalIDNumber"];
    $birthdate = $_POST["additionalBirthDate"];
    $homephone = $_POST["additionalHomePhone"];
    $workphone = $_POST["additionalWorkPhone"];
    $mobilephone = $_POST["additionalMobilePhone"];
    $homeemail = $_POST["additionalHomeEmail"];
    $workemail = $_POST["additionalWorkEmail"];
    $relationshipId = $_POST["additionalRelationship"];

    $stmt = $db->conn->prepare("SELECT * FROM tblpersons WHERE FirstName = :firstname AND LastName = :lastname AND DateOfBirth = :birthdate");
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->execute();
    $result = $stmt->fetch();

    $insertInPersonPolicies = false;

    if ($result[0] != null && $personId == $result['PersonId']) { // record exists
        $stmt = $db->conn->prepare($stmt_per_edit);
        $stmt->bindParam(':policyid', $polid);
        $stmt->bindParam(':personid', $personId);
    }
    else { //add new
        $stmt = $db->conn->prepare($stmt_per_add);
        $insertInPersonPolicies = true;
    }
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':middlenames', $middlenames);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':titleid', $titleid);
    $stmt->bindParam(':idnumber', $idnumber);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':homephone', $homephone);
    $stmt->bindParam(':workphone', $workphone);
    $stmt->bindParam(':mobilephone', $mobilephone);
    $stmt->bindParam(':homeemail', $homeemail);
    $stmt->bindParam(':workemail', $workemail);
    $stmt->execute();

    $p = new Person;
    $pp = new PolicyPerson;
    
    if ($insertInPersonPolicies)  {
        $personId = $p->GetLatestId($firstname, $lastname);
        $pp->Create($polid, $personId, $personTypeId, $relationshipId, $userId);
    }
    else {
        $pp->Update($polid, $personId, $personTypeId, $relationshipId, $userId);        
    }
}


$_SESSION["Saved"] = "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Saved Successfully.</div>";
header("location:details.php?polid=". $polid ."&mode=view");
?>