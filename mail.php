<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Content-Type: application/json");

//UTILIZACAO DO COMPOSER
if(file_exists("vendor/autoload.php")){
	require("vendor/autoload.php");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class mails {

    public function run($data){

        try {

            $mail = new PHPMailer(true);
        
            $mail->SMTPDebug    = false;
            $mail->Host         = "smtp.gmail.com";
            $mail->SMTPAuth     = true;
            $mail->Username     = getenv("MAIL_NAME");
            $mail->Password     = getenv("MAIL_PASS");
            $mail->Port         = 587;
            $mail->CharSet      = "UTF-8";
        
            $mail->setFrom(getenv("MAIL_NAME"), "Notification - Website");
            $mail->isSMTP();
            
            //DETERMINANDO REMETENTE
            $mail->addAddress(getenv("MAIL_MYGM"), getenv("MAIL_MYNM"));
        
            //DETERMINANDO ASSUNTO
            $mail->Subject = "Contato Via Website - Assunto Diverso";
        
            //DETERMINANDO CORPO
            $mail->Body    = $data;

            //CONVERT HTML
            $mail->isHTML(true);
        
            $mail->send();
        
            return true ;
        
        } catch (Exception $e) {
        
            return false ;
        
        }

    }

}

//CAPTURAR DADOS
$name   = (isset($_POST["name"]))   ? $_POST["name"]    : "" ;
$email  = (isset($_POST["email"]))  ? $_POST["email"]   : "" ;
$phone  = (isset($_POST["phone"]))  ? $_POST["phone"]   : "" ;
$body   = (isset($_POST["body"]))   ? $_POST["body"]    : "" ;

//MONTANDO EMAIL
$data 	= htmlentities(file_get_contents("mail.html", FILE_BINARY));

$data   = str_replace("#NAME#", $name,    $data);
$data   = str_replace("#MAIL#", $email,   $data);
$data   = str_replace("#FONE#", $phone,   $data);
$data   = str_replace("#BODY#", $body,    $data);

//ENVIANDO EMAIL
$mails = new mails();

//RESPONSE
echo json_encode(array("response" => $mails->run($data)));