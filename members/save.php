<?php
include_once "../inc/sessions.php";

require "../inc/config.inc.php";
require "../classes/classes.php";

$polid = $_POST["polid"];
$mode  = $_POST["mode"];

try {

    $err = '';

    $db = new DbConn;
    $pol = new Policy;
    $per = new Person;
    $pp = new PolicyPerson;
    
    $manualpolicynumber = $_POST["manualPolicyNumber"];
    $policyplanid = $_POST["policyPlan"];
    $policyPremium = $_POST["policyPremium"];
    $policystartdate = $_POST["policyStartDate"];
    $policyenddate = $_POST["policyEndDate"];
    $agentname = (isset($_POST["agentName"]) ? $_POST["agentName"] : "");
    $agentcode = (isset($_POST["agentCode"]) ? $_POST["agentCode"] : "");

    $policystartdate = isnull($policystartdate, NULL);
    $policyenddate = isnull($policyenddate, NULL);

    if($mode=="edit") {
        $pol->Update($polid, $manualpolicynumber, $policyplanid, $policyPremium, $policystartdate, $policyenddate, $userId);
    }
    else {
        $policynumber = $_POST["policyNumber"];
        $polid = $pol->Create($policynumber, $manualpolicynumber, $policyplanid, $policyPremium, $policystartdate, $policyenddate, $agentname, $agentcode, $userId);
    }

    AddThisPerson($polid, 1);
    AddThisPerson($polid, 2);

} catch (PDOException $e) {
    
    $err = "Error: " . $e->getMessage();
}

function AddThisPerson($polid, $personTypeId) {
    $pp = New PolicyPerson;
    $per = New Person;
    $userId = $_SESSION["UserId"];

    switch($personTypeId) {
        case 1:
        case "1":
            $firstName = $_POST["mainFirstName"];
            $middleNames = $_POST["mainMiddleNames"];
            $lastName = $_POST["mainLastName"];
            $titleId = $_POST["mainTitle"];
            $idNumber = $_POST["mainIDNumber"];
            $birthDate = $_POST["mainBirthDate"];
            $homePhone = $_POST["mainHomePhone"];
            $workPhone = $_POST["mainWorkPhone"];
            $mobilePhone = $_POST["mainMobilePhone"];
            $homeEmail = $_POST["mainHomeEmail"];
            $workEmail = $_POST["mainWorkEmail"];
            $personId = $_POST["mainPersonId"];
            break;
        case 2:
            $firstName = $_POST["spouseFirstName"];
            $middleNames = $_POST["spouseMiddleNames"];
            $lastName = $_POST["spouseLastName"];
            $titleId = $_POST["spouseTitle"];
            $idNumber = $_POST["spouseIDNumber"];
            $birthDate = $_POST["spouseBirthDate"];
            $homePhone = $_POST["spouseHomePhone"];
            $workPhone = $_POST["spouseWorkPhone"];
            $mobilePhone = $_POST["spouseMobilePhone"];
            $homeEmail = $_POST["spouseHomeEmail"];
            $workEmail = $_POST["spouseWorkEmail"];
            $personId = $_POST["spousePersonId"];
            break;
        default:
            echo "Undefined PersonTypeID<br>";
            return;
    }
    leratomotsoane
    if ($firstName == null || $lastName == null) {
        return;
    }
    
    if (isnull($personId,0) == 0) {//if person was not loaded on the form
        $result = $pp->GetByPolicyId($polid, $personTypeId);
        $personId = $result["PersonId"];
    }

    if (isnull($personId,0) == 0) {//if policy doesn't have the persontype, get the person by Id
        $result = $per->GetByIDNumber($idNumber);
        $personId = $result["PersonId"];
    }

    if (isnull($personId,0) == 0) {//if the person can't be found by ID Number, get by names and date of birth
        $personId = $per->GetLatestId($firstName, $lastName, $birthDate);
    }

    if (isnull($personId,0) > 0) {
        $per->Update($personId, $firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId);
    }
    else { //add new
        $personId = $per->Create($firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId);
    }
    
    $result = $pp->GetByPolicyId($polid, $personTypeId);
    
    if ($result["PersonPolicyId"] != NULL) {
        $pp->Update($polid, $personId, $personTypeId, 1, $userId);
    }
    else {
        $pp->Create($polid, $personId, $personTypeId, 1, $userId);
    }
}

function AddPerson($polid, $personTypeId) {
    $userId = $_SESSION["UserId"];

    echo "UserID{$personTypeId}={$userId}<br>";

    switch ($personTypeId)
    {
        case 1:
            break;

        case 2:
            $firstName = $_POST["spouseFirstName"];
            $middleNames = $_POST["spouseMiddleNames"];
            $lastName = $_POST["spouseLastName"];
            $titleId = $_POST["spouseTitle"];
            $idNumber = $_POST["spouseIDNumber"];
            $birthDate = $_POST["spouseBirthDate"];
            $homePhone = $_POST["spouseHomePhone"];
            $workPhone = $_POST["spouseWorkPhone"];
            $mobilePhone = $_POST["spouseMobilePhone"];
            $homeEmail = $_POST["spouseHomeEmail"];
            $workEmail = $_POST["spouseWorkEmail"];
            $personId = $_POST["spousePersonId"];
            break;
    }

    echo "FirstName{$personTypeId}={$firstName}<br>";

    $per = new Person;

    echo "LastName{$personTypeId}={$lastName}<br>";
    
    $pp = new PolicyPerson;
    if (isnull($personId,'') == '') {
        $result = $pp->GetByPolicyId($polid, $personTypeId);
        $personId = $result["PersonId"];
    }
    echo "uPersonId=". $personId ."<br>";
    
    if ($personId != null) { // record exists
        $per->Update($personId, $firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId);
        $pp->Update($polid, $personId, $personTypeId, 1, $userId);
    }
    else { //add new
        echo "IDNumber{$personTypeId}={$idNumber}<br>";
        $personId = $per->Create($firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId);
        echo "cPersonId=". $personId;
        $pp->Create($polid, $personId, $personTypeId, 1, $userId);
    }
}
    

$_SESSION["Saved"] = "<div class=\"alert alert-success alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Saved Successfully.</div>";
header("location:details.php?polid=". $polid ."&mode=view");
?>