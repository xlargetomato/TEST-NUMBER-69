<?php
function enc($text, $key){
    if($text != "" && $key != ""){
        $Secertkey = md5($key);
        $vv = substr( hash( 'sha256', "aaaabbbbcccccccdddddeweees" ), 0, 16 );
        $encText = openssl_encrypt($text, 'AES-128-CBC', $Secertkey, OPENSSL_RAW_DATA, $vv);
        return base64_encode($encText);
    }
    return "Error";
}

function   dec($text, $key){
    if($text != "" && $key != ""){
        $Secertkey = md5($key);
        $vv = substr( hash( 'sha256', "aaaabbbbcccccccdddddeweees" ), 0, 16 );
        $decText = openssl_decrypt(base64_decode($text), 'AES-128-CBC', $Secertkey, OPENSSL_RAW_DATA, $vv);
    return $decText;
    }elseif($text == ""){
        return "text not provided.";
    }elseif($key == ""){
        return "key not provided.";
    }else{
    return "Error";
    }
}
include "sql.php";
ob_start();
session_start();
if (dec($_POST['key'], "elgmeza") == $_COOKIE['PHPSESSID'] . "sakgddgdsgsdgdg3441252") {
    if ($_POST['user'] != "" AND $_POST['pass'] != "") {
        if ($MM) {
            $user = $_POST["user"];
            $pass = $_POST["pass"];
            
            // Use prepared statements to prevent SQL injection
            $stmt = mysqli_prepare($MM, "SELECT * FROM `usr` WHERE `username`=? AND `password`=?");
            mysqli_stmt_bind_param($stmt, "ss", $user, $pass);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if ($query = mysqli_fetch_assoc($result)) {
                $_SESSION['level'] = $query['level'];
                $_SESSION['username'] = $query['username'];
                $_SESSION['name'] = $query['name'];
                echo "success" . "-" . $query['name'];
            } else {
                echo "failed";
            }
        } else {
            echo "database connection error please contact the developer.";
        }
    } else {
        echo "Missing info.";
    }
} else {
    echo "Enc Error.";
}
die();
?>
