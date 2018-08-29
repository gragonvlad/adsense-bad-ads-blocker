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

if ($_POST['Pin'])
    if (is_data_safely($_POST['Pin'])) {

        $sms_form = file($GLOBALS['temp_folder'] . '2authsmsform', FILE_IGNORE_NEW_LINES);
        $url = array_shift($sms_form);
        $ref_url = array_shift($sms_form);

        foreach ($sms_form as $input) {

            if ($input == 'Pin=')
                $inputs[] = $input . $_POST['Pin'];
            else
                $inputs[] = $input;
        }
        $inputs = implode('&', $inputs);

        $result_auth3 = curl_post($url, $inputs, $ref_url, '');

        if (isset($set['log']))
            create_log($result_auth3, 'answer7res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_1res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_2res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_3res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_4res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_5res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_6res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_7res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_8res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_9res_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer7_10res_auth');


        $forms = auth2stage($result_auth3); // check remind form
        if (isset($forms['remind'])) {
            $result_auth3 = remind_me_later($forms['remind']); //submit remind form
        }

        if (isset($set['log']))
            create_log($result_auth3, 'answer8rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_1rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_2rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_3rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_4rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_5rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_6rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_8rem_fo_auth');
        $result_auth3 = redirect_check($result_auth3);
        if (isset($set['log']))
            create_log($result_auth3, 'answer8_9rem_fo_auth');

        $result_auth3 = hex_repl($result_auth3);

        $to_out = log_in_check($result_auth3);

        if ($to_out)
            echo $to_out;
        else
            echo 'Something went wrong.';

    }
//—
 ?>
</body>
</html>