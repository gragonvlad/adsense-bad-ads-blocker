<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
* { font-size: 20px;  font-family: Calibri, Verdana, Arial; }
body { background: #fff; }
</style>
</head>
<body>
<?php include 'functions.php';
include 'login_functions.php';

if (!isset($_POST['password']))
    die('Password required.');
if ($_POST['password'] == '')
    die('Password required.');
//if(!is_data_safely($_POST['password']))	  die();

if (file_exists($GLOBALS['cookie_file']))
    unlink($GLOBALS['cookie_file']); //delete prev cookie
if (file_exists($GLOBALS['temp_folder'] . 'pub_id.txt'))
    unlink($GLOBALS['temp_folder'] . 'pub_id.txt'); //delete prev pub id


$login_files = scandir($GLOBALS['temp_folder']);
unset($login_files[0], $login_files[1]); //removes . and ..
foreach ($login_files as $login_file) {
    if (mb_strpos($login_file, '.cron.', null, 'UTF-8') !== false) {
        unlink($GLOBALS['temp_folder'] . '/' . $login_file);
    }
}


/**
 * —*	Get login form
 */
$url = 'https://accounts.google.com/ServiceLogin?continue=https%3A%2F%2Fwww.google.com%2Fadsense%2Fgaiaauth2%3Fhl%3Den%26noaccount%3Dfalse&rip=1&nojavascript=1&followup=https%3A%2F%2Fwww.google.com%2Fadsense%2Fgaiaauth2%3Fhl%3Den%26sourceid%3Daso%26noaccount%3Dfalse%26marketing%3Dtrue&service=adsense&rm=hide&ltmpl=adsense&hl=en_US&alwf=true';
$first_result = curl_get($url, 'https://google.com/adsense/', $GLOBALS['myheaders']);

if (isset($set['log']))
    file_put_contents($GLOBALS['temp_folder'] . 'logs/answer1.' . time(), $first_result);

if (trim($first_result) == '') {
    die('Error: empty first answer. It could be DNS fail...');
}

sleep(rand(2, 3));
/**
 * Get password form
 */

$login_result = password_form($first_result, $set['login'], $url);

if (isset($set['log']))
    file_put_contents($GLOBALS['temp_folder'] . 'logs/answer2res_log' . time(), $login_result);

if (trim($login_result) == '') {
    die('Error: empty login answer. It could be DNS fail...');
}

sleep(rand(2, 3));

if (stripos($login_result, 'errormsg_0_Email') !== false) {
    die('<p>Sorry, Google doesn\'t recognize that emai. Please check email and try again.</p>');
}

/**
 *  Password send
 */

$result_auth = password_send($login_result, $_POST['password']);

if (isset($set['log'])) {
    file_put_contents($GLOBALS['temp_folder'] . 'logs/answer3res_auth' . time(), $result_auth);
    $result_tmp = $result_auth;
}

if (trim($result_auth) == '') {
    die('Error: empty auth answer. It could be DNS fail...');
}


$result_auth = redirect_check($result_auth);

if (isset($set['log']))
    create_log($result_auth, 'answer3_1res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_2res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_3res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_4res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_5res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_6res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_7res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_8res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_9res_auth');
$result_auth = redirect_check($result_auth);
if (isset($set['log']))
    create_log($result_auth, 'answer3_10res_auth');

$GLOBALS['result_tmp'] = '';


if (stripos($result_auth, 'Wrong password') !== false) {
    die('<p>Wrong password. Please check input language and try again.</p>');
}

if (stripos($result_auth, 'name="logincaptcha"') !== false) {
    die('<p>Captcha is. Try to add phone number to your Google account.</p>');
}


$to_out = log_in_check($result_auth);


if ($to_out)
    echo $to_out;
else {

    /**
     * 2-stage auth
     */
    $protect_counter = 0;

    auth2stage : $result_auth = redirect_check($result_auth);
    $forms = auth2stage($result_auth);

    if (isset($set['log']))
        file_put_contents($GLOBALS['temp_folder'] . 'logs/answer4res_auth' . time(), $result_auth);

    after_first_page : if ($protect_counter >= 3)
        exit('too many jumps');

    if (isset($forms['sms'])) { //we have SMS-code input form

        sms_form_save($forms['sms']);

    } else
        if (isset($forms['pre_sms'])) { //we have button "Send SMS-code"

            sleep(rand(2, 3));
            $result_auth = pre_sms_press($forms['pre_sms']);

            if (isset($set['log']))
                create_log($result_auth, 'answer5pre_sms');
            $result_auth = redirect_check($result_auth);
            if (isset($set['log']))
                create_log($result_auth, 'answer5_1pre_sms');
            $result_auth = redirect_check($result_auth);
            if (isset($set['log']))
                create_log($result_auth, 'answer5_2pre_sms');

            $protect_counter++;
            goto auth2stage;

        } else
            if (isset($forms['change'])) { //we have button to page of changing auth type

                sleep(rand(1, 2));
                $forms = change_method($forms['change']);
                $protect_counter++;
                goto after_first_page;
            }

    /**
     * 2-stage auth end
     */
} ?>
</body>
</html>