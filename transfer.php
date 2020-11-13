<?php 
    if(isset($_REQUEST['amount']) && isset($_REQUEST['origin_account_number']) && isset($_REQUEST['target_account_number'])){
        $amount = $_REQUEST['amount'];
        $origin_account_number = $_REQUEST['origin_account_number'];
        $target_account_number = $_REQUEST['target_account_number'];
        $amount = $_REQUEST['amount'];
        $cnx =  mysqli_connect("localhost","root","","dbbank");
        mysqli_query($cnx,"SET NAMES 'utf8'");
        $response = "";
        $resultOrigin = $cnx->query("SELECT `accountnumber`, `balance` FROM `account` WHERE accountnumber = $origin_account_number");
        $resultTarget = $cnx->query("SELECT `accountnumber`, `balance` FROM `account` WHERE accountnumber = $target_account_number");
        while ($row = $resultOrigin->fetch_assoc()) {
            $balanceOrigin = $row['balance'];
        }
        while ($row = $resultTarget->fetch_assoc()) {
            $balanceTarget = $row['balance'];
        }
        if ($origin_account_number == $target_account_number || mysqli_num_rows($resultOrigin) == 0 || mysqli_num_rows($resultTarget) == 0){
            $response = "0";
            echo $response;
            return;
        }
        $resultBalanceCheck = (int)$balanceOrigin - (int)$amount;
        if ($balanceOrigin <= 10000 || (int)$amount >= (int)$balanceOrigin || (int)$resultBalanceCheck < 10000) {
            $response = "2";
            echo $response;
            return;
        }
        $updatedBalanceOrigin = (int)$balanceOrigin - (int)$amount;
        $updatedBalanceTarget = (int)$balanceTarget + (int)$amount;
        $insertTransaction = $cnx->query("INSERT INTO `transaction`(`origin_account_number`, `target_account_number`, `amount`) VALUES ($origin_account_number, $target_account_number, $amount)");
        
        $updateOrigin = $cnx->query("UPDATE `account` SET `balance`=  $updatedBalanceOrigin WHERE `accountnumber` = $origin_account_number");
        $updateTarget = $cnx->query("UPDATE `account` SET `balance`=  $updatedBalanceTarget WHERE `accountnumber` = $target_account_number");
        $updateBalanceQ= $cnx->query("SELECT `balance` FROM `account` WHERE accountnumber = $origin_account_number");
        while ($row = $updateBalanceQ->fetch_assoc()) {
            $updateBalance = $row['balance'];
        }
        $response = $updateBalance;
        echo $response;
        mysqli_close($cnx);
    }

?>