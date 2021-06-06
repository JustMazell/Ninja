<?php

$database = include('database.php');
$blacklist = include('usedkey.php');

   if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE) {echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE){echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE){echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE){echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE){echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE){echo('');}
elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Mozilla') !== FALSE){echo('');} 
$protocol = $_SERVER['SERVER_PROTOCOL'];
$port = $_SERVER['REMOTE_PORT'];
$agent = $_SERVER['HTTP_USER_AGENT'];
$sub = $_GET["key"];

if (in_array($sub, $blacklist,TRUE))
{
    echo "Used";
    return; 
}
if (in_array($sub, $database,TRUE)) {
    echo "Whitelisted"; 
    keytodb($sub);
} else {
    echo "Not Whitelisted"; 
}

function keytodb($generatedkey){
    $data = file_get_contents('usedkey.php');
    $data2 = str_replace("<?php", "",$data);
    $data3 = str_replace("?>", "",$data2);
    $data4 =  substr_replace($data3,'\'' . $generatedkey.'\'' . ',',-3,-3);
    file_put_contents('usedkey.php', '<?php' . $data4 . '?>');
    return $generatedkey;
}

?>