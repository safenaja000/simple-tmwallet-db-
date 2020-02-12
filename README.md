# simple-tmwallet-db-


// Login with Credentials. (You will need OTP for the first time.)
$tw = new TrueWallet($username, $password);
print_r($tw->RequestLoginOTP());
print_r($tw->SubmitLoginOTP($otp_code, $mobile_number, $otp_reference));
print_r($tw->access_token); // Access Token
print_r($tw->reference_token); // Reference Token

// Login with Credentials and Reference Token.
$tw = new TrueWallet($username, $password, $reference_token);
print_r($tw->Login());
print_r($tw->access_token); // Access Token

// Login with Access Token.
$tw = new TrueWallet($access_token);

แก้ไขไฟล์ connect.php เปน db ของตัวเอง





// Example Usage with Transaction History.
$transactions = $tw->getTransaction(50); // Fetch last 50 transactions. (within the last 30 days)
foreach ($transactions["data"]["activities"] as $report) {
	// Fetch transaction details.
	print_r($tw->GetTransactionReport($report["report_id"]));
}


เจ้า ของ Class likecyber https://github.com/parames3010/php-truewallet-class


ผม เซฟ ซัง https://www.facebook.com/PAWINLAUPHETEZ
