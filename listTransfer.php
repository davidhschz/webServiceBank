<?php
    if (isset($_REQUEST['account'])) {
        $account = $_REQUEST['account'];
        $cnx =  mysqli_connect("localhost","root","","dbbank");
		mysqli_query($cnx,"SET NAMES 'utf8'");
		$res = $cnx->query("select * from transaction where origin_account_number = $account");
		$json = array();
		foreach ($res as $row) 
		{
			$json['transaction'][]=$row;
		}
		echo json_encode($json,JSON_UNESCAPED_UNICODE);	
    }
?>