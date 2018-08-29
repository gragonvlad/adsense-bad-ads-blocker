<?php include '../functions.php';

$bad = 0;
foreach ($_POST as $value) {
    if (!is_data_safely($value))
        $bad = 1;
}

if (!$bad) {
    $settings = json_encode($_POST);
    file_put_contents($GLOBALS['settings_folder'] . 'settings.ini', $settings);
}
header("Location: " . $_SERVER['HTTP_REFERER']);
//—
 ?>