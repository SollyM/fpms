<?php
//Class Autoloader
spl_autoload_register(function ($className) {

    $className = strtolower($className);
    $path = "../classes/{$className}.php";

    if (file_exists($path)) {

        require_once($path);

    } else {

        die("The file {$path} could not be found.");

    }
});

function formatCurrency($pre, $value, $post){
    return $pre . sprintf(' %0.2f', $value) . $post;
  }

function generatePolicyNumber()
{
//    return "DK". date("Y") ."/". ("0000". rand(0000,1000)) ."/01";
    return "DK". date("Y") ."/". rand(1000,9999) ."/01";
}

function isnull($obj, $value) {
    if ($obj == NULL || $obj == '')
        return $value;
    return $obj;
}

function checkAttempts($username)
{

    try {

        $db = new DbConn;
        $conf = new GlobalConfig;
        $tbl_attempts = $db->tbl_attempts;
        $ip_address = $conf->ip_address;
        $err = '';

        $sql = "SELECT Attempts as attempts, lastlogin FROM ".$tbl_attempts." WHERE ipaddress = :ip and Username = :username";

        $stmt = $db->conn->prepare($sql);
        $stmt->bindParam(':ip', $ip_address);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;

        $oldTime = strtotime($result['lastlogin']);
        $newTime = strtotime($datetimeNow);
        $timeDiff = $newTime - $oldTime;

    } catch (PDOException $e) {

        $err = "Error: " . $e->getMessage();

    }

    //Determines returned value ('true' or error code)
    $resp = ($err == '') ? 'true' : $err;

    return $resp;

};

function mySqlErrors($response)
{
    //Returns custom error messages instead of MySQL errors
    switch (substr($response, 0, 22)) {

        case 'Error: SQLSTATE[23000]':
            echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>Username or email already exists</div>";
            break;

        default:
            echo "<div class=\"alert alert-danger alert-dismissable\"><button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-hidden=\"true\">&times;</button>An error occurred... try again</div>";

    }
};

function esc_url($url) {
    
       if ('' == $url) {
           return $url;
       }
    
       $url = preg_replace('|[^a-z0-9-~+_.?#=!&;,/:%@$\|*\'()\\x80-\\xff]|i', '', $url);
    
       $strip = array('%0d', '%0a', '%0D', '%0A');
       $url = (string) $url;
    
       $count = 1;
       while ($count) {
           $url = str_replace($strip, '', $url, $count);
       }
    
       $url = str_replace(';//', '://', $url);
    
       $url = htmlentities($url);
    
       $url = str_replace('&amp;', '&#038;', $url);
       $url = str_replace("'", '&#039;', $url);
    
       if ($url[0] !== '/') {
           // We're only interested in relative links from $_SERVER['PHP_SELF']
           return '';
       } else {
           return $url;
       }
   }