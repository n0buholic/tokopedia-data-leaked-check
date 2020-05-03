<?php
require_once 'config.php';

function searchByEmail($mysqli, $email) {
    $query = $mysqli->query("SELECT * FROM email WHERE email='$email'");
    if (mysqli_num_rows($query) > 0) {
        return true;
    } else {
        return false;
    }
}

$email = @$_GET['email'];

$result = array(
    "success"    => false,
    "data"       => array(
        "email"     => $email,
        "leaked"    => null,
    ),
    "message"   => null,
    "credit"    => "Powered by HelixProject"
);

header('Content-Type: application/json');

if (!isset($email) || empty($email)) {
    $result['message'] = "No email was given.";
} else {
    $result['success'] =  true;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $result['message'] = "The email given was invalid.";
    } else {
        $search = searchByEmail($mysqli, $email);
        if ($search === false) {
            $result['data']['leaked'] = false;
            $result['message'] = "Nothing found, your email is safe.";
        } else {
            $result['data']['leaked'] = true;
            $result['message'] = "Your email was leaked on Exclusive - Tokopedia, 15 million users.";
        }
    }
}

die(json_encode($result, JSON_PRETTY_PRINT));