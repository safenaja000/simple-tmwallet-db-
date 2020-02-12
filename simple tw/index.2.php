<?php
    if(isset($_POST['id'])){
        $id = $_POST['id'];
        $user = 'safe';
        require_once('connect.php');
        require_once("TrueWallet.class.php");
        $username = '@hotmail.com';
        $password = '';
        $reference_token = '';
        //$tw = new TrueWallet($username, $password);
        //print_r($tw->RequestLoginOTP());
        //print_r($tw->SubmitLoginOTP('', '', ''));
        //print_r($tw->access_token); // Access Token 
        //echo '<br>';
        //print_r($tw->reference_token); // Reference Token 
        $tw = new TrueWallet($username, $password, $reference_token);
        $tw->Login();
        $transactionsReport = array(
            'id' => [],
            'amount' =>[]
        );
        $transactions = $tw->getTransaction(50); // Fetch last 50 transactions. (within the last 30 days)
            echo '<pre>';
            //print_r($transactions);
            echo '</pre>';
            echo '<hr>';
            foreach ($transactions["data"]["activities"] as $report) {
                // Fetch transaction details.
                echo '<pre>';
                $s1 = $tw->GetTransactionReport($report["report_id"]);
                echo '</pre>';
                    //print_r($s1);
                $Ref = $s1['data']['section4']['column2']['cell1']['value'];
                    array_push($transactionsReport['id'], $Ref);
                $money = $s1['data']['section3']['column1']['cell1']['value'];
                    array_push($transactionsReport['amount'],$money);
            }
            $sql_select_log = "SELECT * FROM `log` WHERE `Ref` = '$id'";
            $result_select_log = mysqli_query($conn,$sql_select_log);
            $log = mysqli_fetch_assoc($result_select_log);
                if(!isset($log['Ref'])){
                    $check = false;
                    foreach($transactionsReport['id'] as $i=>$value){   
                        if($value ==  $id){
                            $amount = $transactionsReport['amount'][$i];
                            $sql_insert = "INSERT INTO `log`(`Ref`, `amount`,`Username`) VALUES ('$id','$amount','$user')";
                            $result_insert = mysqli_query($conn,$sql_insert);
                            $amountpoint = $amount * 100;
                            $sql_select = "SELECT `point` FROM `user` WHERE Username = '$user'";
                            $result_select = mysqli_query($conn,$sql_select);
                            $row = mysqli_fetch_assoc($result_select);
                            $result_amount = $row['point'] += $amountpoint;
                            $sql_update = "UPDATE `user` SET `point`='$result_amount' WHERE Username = '$user'";
                            $result_update = mysqli_query($conn,$sql_update);
                            $check = true;
                            echo 'เงินเข้าแล้ว'.$amount .'บาท';
                            break;
                        } 
                    }echo $check == true ? '':'รหัสอ้างอิงผิด';
                }else{
                    echo 'กรอกรหัสไปแล้ว';
                }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post">
        <input type="text" placeholder="เลขอ้างอิง" name="id">
        <button type="submit">ตกลง</button>
    </form>
</body>
</html>