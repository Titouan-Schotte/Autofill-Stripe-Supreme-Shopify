<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="assets/icon.png">
    <title>AuthDiscord</title>
</head>
<body>
<center><h1>Authentification by Discord</h1></center>
<br><br>
<script type="text/javascript">
    var refresh = window.location.protocol + "//" + window.location.host + window.location.pathname;
    window.history.pushState({path: refresh}, '', refresh);

</script>
<?php

//LOGING PAGE

$log = 'Log In';
ini_set('display_errors', 'off');
ini_set('display_startup_errors', 1);
ini_set('max_execution_time', 300); //300 seconds = 5 minutes. In case if your CURL is slow and is loading too much (Can be IPv6 problem)

error_reporting(E_ALL);

define('OAUTH2_CLIENT_ID', <YOUR OAUTH2 CLIENT ID>);
define('OAUTH2_CLIENT_SECRET', <YOUR OAUTH2 CLIENT SECRET>);

$authorizeURL = 'https://discord.com/api/oauth2/authorize';
$tokenURL = 'https://discord.com/api/oauth2/token';
$apiURLBase = 'https://discord.com/api/users/@me';

session_start();

// LOGIN
if (get('action') == 'login') {

    $params = array(
        'client_id' => OAUTH2_CLIENT_ID,
        'redirect_uri' => '',
        'response_type' => 'code',
        'scope' => 'identify guilds'
    );

    // Redirect the user to Discord's authorization page
    echo '<script>window.open("https://discord.com/api/oauth2/authorize' . '?' . http_build_query($params) . '", "_blank");</script>';
    echo "<center><p>To show the discord page, please allow pop-ups !</p></center>";
    die();
}


// When Discord redirects the user back here, there will be a "code" and "state" parameter in the query string
if (get('code')) {

    // Exchange the auth code for a token
    $token = apiRequest($tokenURL, array(
        "grant_type" => "authorization_code",
        'client_id' => OAUTH2_CLIENT_ID,
        'client_secret' => OAUTH2_CLIENT_SECRET,
        'redirect_uri' => '',
        'code' => get('code')
    ));
    $logout_token = $token->access_token;
    $_SESSION['access_token'] = $token->access_token;


    header('Location: ' . $_SERVER['PHP_SELF']);
}

if (session('access_token')) {
    $user = apiRequest($apiURLBase);
    echo '<h3>Logged In</h3>';
    echo '<h4>Welcome, ' . $user->username . "#" . $user->discriminator . '</h4>';
    //echo "<script type='text/javascript'>localStorage.setItem('connect', true)</script>";
} else {
    echo '<h3>Not logged in</h3>';
    $log = 'Log In';
    echo "<script type='text/javascript'>localStorage.setItem(\"connect\", 0);</script>";
    $what = "<center><a href='?action=login'><button class='log'>" . $log . "</button></a></center>";
}



function apiRequest($url, $post = FALSE, $headers = array())
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

    $response = curl_exec($ch);


    if ($post)
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));

    $headers[] = 'Accept: application/json';

    if (session('access_token'))
        $headers[] = 'Authorization: Bearer ' . session('access_token');

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    return json_decode($response);
}

function get($key, $default = NULL)
{
    return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
}

function session($key, $default = NULL)
{
    return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
}


//FTP FILE

if (isset($user)) {
    $id = $user->id;
} else {
    $id = 0;
}
$p = "";
if ($id != 0) {

    //DISCORD PROMPT
    $conn_id = ftp_connect(<YOUR DOMAIN NAME>);
    ftp_login($conn_id, <USERNAME>, <PASSWORD>);
    ftp_pasv($conn_id, true);
    $h = fopen('php://temp', 'r+');
    ftp_fget($conn_id, $h, 'user.txt', FTP_BINARY, 0);
    $fstats = fstat($h);
    fseek($h, 0);
    $contents = fread($h, $fstats['size']);
    $p = "<br><br><center><p class='result'>Your are not in the Discord server !<br> Go to <a href='url of hyper discord' style='color: #700bcf'>this site</a> to purchase your access.</p></center><br><p>";
    $data_list = explode(',', $contents);

    //for


    //VERIF
    for ($i = 0; $i <= sizeof($data_list) - 1; $i++) {
        if ($id == $data_list[$i]) {
            echo "<script type='text/javascript'>localStorage.setItem(\"connect\", 1);</script>";
            $p = "<br><br><center><p class='result' style='color: #700bcf'>Everything is alright, you can close this page !</p></center>";
        }
    }


    //echo $contents;
    fclose($h);
    ftp_close($conn_id);
}
?>

<div class="result">
    <?php echo $p ?><br><br><br>

</div>
<?php echo $what ?>

</body>
</html>