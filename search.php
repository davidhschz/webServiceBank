<?php 
    if (isset($_REQUEST['user']) && isset($_REQUEST['password'])){
        $user = $_REQUEST['user'];
        $password = $_REQUEST['password'];
        $cnx =  mysqli_connect("localhost","root","","dbbank");
        mysqli_query($cnx,"SET NAMES 'utf8'");
        $res = $cnx->query("select user, name from client where user = '$user' and password = '$password'");
        $json = array();
        foreach ($res as $row) 
        {
            $json['client'][]=$row;
        }
        $res = $cnx->query("select accountnumber, balance from account where user = '$user'");
        foreach ($res as $row) 
        {
            $json['account'][]=$row;
        }
        echo json_encode($json,JSON_UNESCAPED_UNICODE);
    }
?>