<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <title>Key system</title>
<link rel="icon" href="fav.svg" type="image/x-icon" />
</head>

<body>
    <h1 style="text-align: center;">Panda-Technology Key System</h1>
    <p style="text-align: center;">Copyright(C)Panda-Technology-2020</p>
    <p style="text-align: center;">Thank you for choosing Panda-Technologies</p>
    <p style="text-align: center;">----------------------------------------------------------------------------------------------------</p>

    <style>
    .text-center {
        text-align: center;
    }

    .g-recaptcha {
        display: inline-block;
    }
    </style>
<div class="text-center">
    <form action="" method="POST" id="Captcha">
    <div class="g-recaptcha" data-callback="recaptchaCallback"
    data-sitekey="( your site key )" id="google"></div>
    </form>
    </div>
    <p id="Notif"style="text-align: center;">Please check the recaptcha to get your key</p>
</body>
<script>
function recaptchaCallback() {
    document.getElementById('Captcha').submit()
}
</script>
</html>


<?php
//CHECKING FOR THE CAPTCHA AND PERFORMING THE FUNCTIONS DEPENDING ON THE CASES
if (isset($_POST['g-recaptcha-response'])){
    $secret = 'Your Secret Key';
    $response = $_POST['g-recaptcha-response'];
    $remoteip = $_SERVER['REMOTE_ADDR'];
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $response . '&remoteip=' . $remoteip;
    $response = file_get_contents($url);
    $jsResponse = json_decode($response, true);
    if($jsResponse['success'] == 1 ){
        $key = keytodb(generatekey(25));
        echo '<script> document.getElementById("Notif").innerHTML = "Here is your generated key!" </script>';
        echo '<script> document.getElementById("google").style.display = "none";</script>';
        echo '<h3><center>' . $key . '</center></h3>';
    }else{
        echo '<script> document.getElementById("Notif").innerHTML = "Make sure the recaptcha is checked!" </script>';
    }
}



// GENERATING THE RANDOM KEY

function generatekey($length){

 $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

 $charactersLength = strlen($characters);

 $randomString = '';

 for ($i = 0; $i < $length; $i++){

     $randomString .= $characters[rand(0, $charactersLength - 1)];

 }

 return $randomString;

}

// GENERATING THE RANDOM KEY
function keytodb($generatedkey){
    $data = file_get_contents('database.php');
    $data2 = str_replace("<?php", "",$data);
    $data3 = str_replace("?>", "",$data2);
    $data4 =  substr_replace($data3,'\'' . $generatedkey.'\'' . ',',-3,-3);
    file_put_contents('database.php', '<?php' . $data4 . '?>');
    return $generatedkey;
}

// SAVING THE KEY INTO THE DATABASE 

?>








