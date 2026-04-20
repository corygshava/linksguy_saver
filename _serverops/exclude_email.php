<?php
    if(isset($_GET['email']) || isset($_POST['email'])){
        require_once __DIR__.'/functions.php';

        $mypath = __DIR__.'/../_datazone/emails.json';
        $gotten = $_GET['email'] ?? $_POST['email'];
        $email = strip_tags($gotten);

        $rs = update_json($mypath,$email,true);

        if($rs) {
            echo "your email was added successfully";
        } else {
            echo "Email has been added";
        }
    } else {
        echo "pass an email first";
    }
?>