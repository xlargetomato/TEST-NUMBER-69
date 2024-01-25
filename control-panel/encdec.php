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
?>