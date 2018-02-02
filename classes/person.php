<?php
class Person extends ActionLog {
    public function Create($firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId) {
        $personId = $this->GetLatestId($firstName, $lastName, $birthDate);

        if ($personId == NULL) {

            $stmt = $this->conn->prepare("INSERT INTO tblpersons
            (FirstName, MiddleNames, LastName, TitleId, IDNumber, DateOfBirth, HomePhone, WorkPhone, MobilePhone, HomeEmail, WorkEmail)
            VALUES
            (:firstname, :middlenames, :lastname, :titleid, :idnumber, :birthdate, :homephone, :workphone, :mobilephone, :homeemail, :workemail)");
            $stmt->bindParam(':firstname', $firstName);
            $stmt->bindParam(':middlenames', $middleNames);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':titleid', $titleId);
            $stmt->bindParam(':idnumber', $idNumber);
            $stmt->bindParam(':birthdate', $birthDate);
            $stmt->bindParam(':homephone', $homePhone);
            $stmt->bindParam(':workphone', $workPhone);
            $stmt->bindParam(':mobilephone', $mobilePhone);
            $stmt->bindParam(':homeemail', $homeEmail);
            $stmt->bindParam(':workemail', $workEmail);
            $stmt->execute();

            $personId = $this->GetLatestId($firstName, $lastName, $birthDate);

            $this->CreateAction('tblPersons', $personId, $userId);

        }

        return $personId;
    }

    public function GetById($personId) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpersons WHERE PersonId = :personId");
        $stmt->bindParam(':personId', $personId);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetByIDNumber($idNumber) {
        $stmt = $this->conn->prepare("SELECT * FROM tblpersons WHERE IDNumber = :idNumber");
        $stmt->bindParam(':idNumber', $idNumber);
        $stmt->execute();
        return $stmt->fetch();
    }
    
    public function GetLatestId($firstName, $lastName, $birthDate) {
        $stmt = $this->conn->prepare("SELECT MAX(PersonId) PersonId FROM tblpersons WHERE FirstName = :firstName AND LastName = :lastName AND DateOfBirth = :birthDate");
        $stmt->bindParam(':firstName', $firstName);
        $stmt->bindParam(':lastName', $lastName);
        $stmt->bindParam(':birthDate', $birthDate);
        $stmt->execute();
        $result = $stmt->fetch();

        return $result["PersonId"];
    }
    
    public function GetByFullName($firstName, $lastName, $birthDate) {
        $latest = $this->GetLatestId($firstName, $lastName, $birthDate);
        return $this->GetById($latest);
    }

    public function GetByPolicyId($policyId, $personTypeId) {
        $stmt = $this->conn->prepare("SELECT PM.*, PPM.DateAdded
        FROM tblpersons PM
        JOIN lnkpersonpolicies PPM ON PM.PersonId = PPM.PersonId
        WHERE PPM.PolicyId = :policyId AND PersonTypeId = :personTypeId");
        $stmt->bindParam(':policyId', $policyId);
        $stmt->bindParam(':personTypeId', $personTypeId);
        $stmt->execute();
        return $stmt->fetch();  
    }

    public function GetAdditional($policyId) {
        $stmt = $this->conn->prepare("SELECT P.PersonId, P.FirstName, P.MiddleNames, P.LastName, P.TitleId, T.Title, P.DateOfBirth, PP.DateAdded, PT.PersonTypeId, PT.PersonType,
                                             P.IDNumber, P.HomePhone, P.WorkPhone, P.MobilePhone, P.HomeEmail, P.WorkEmail, PP.RelationshipId
                                        FROM lnkpersonpolicies PP
                                        JOIN tblpersons P ON P.PersonId = PP.PersonId
                                        JOIN reftitles T ON T.TitleId = P.TitleId
                                        LEFT JOIN refpersontypes PT ON PT.PersonTypeId = PP.PersonTypeId
                                        WHERE PP.PolicyId = {$policyId} AND PT.PersonTypeId NOT IN (1,2)");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function GetAll() {

    }

    public function Update($personId, $firstName, $middleNames, $lastName, $titleId, $idNumber, $birthDate, $homePhone, $workPhone, $mobilePhone, $homeEmail, $workEmail, $userId) {
        $stmt = $this->conn->prepare("UPDATE tblpersons
                                        SET FirstName    = :firstname,
                                            MiddleNames  = :middlenames,
                                            LastName     = :lastname,
                                            TitleId      = :titleid,
                                            IDNumber     = :idnumber,
                                            DateOfBirth  = :birthdate,
                                            HomePhone    = :homephone,
                                            WorkPhone    = :workphone,
                                            MobilePhone  = :mobilephone,
                                            HomeEmail    = :homeemail,
                                            WorkEmail    = :workemail
                                        WHERE PersonId = :personId");
        $stmt->bindParam(':personId', $personId);
        $stmt->bindParam(':firstname', $firstName);
        $stmt->bindParam(':middlenames', $middleNames);
        $stmt->bindParam(':lastname', $lastName);
        $stmt->bindParam(':titleid', $titleId);
        $stmt->bindParam(':idnumber', $idNumber);
        $stmt->bindParam(':birthdate', $birthDate);
        $stmt->bindParam(':homephone', $homePhone);
        $stmt->bindParam(':workphone', $workPhone);
        $stmt->bindParam(':mobilephone', $mobilePhone);
        $stmt->bindParam(':homeemail', $homeEmail);
        $stmt->bindParam(':workemail', $workEmail);
        $stmt->execute();

        $this->UpdateAction('tblPersons', $personId, $userId);
    }
} 
?>