<?php
namespace Src\Classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Src\Classes\ClassValidate;
class ClassMail{
    private $mail;
    private $Validate;
    
    function __construct(){
        $this->mail = new PHPMailer();
        $this->Validate = new ClassValidate;
    }
    
    function sendMail($email,$nome,$token=null,$assunto,$corpo){
        try {
            //Server settings
            //$this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      
            $this->mail->isSMTP();
            $this->mail->SMTPAuth   = true; 
            $this->mail->Host       = HOSTMAIL;                     
            $this->mail->Username   = USERMAIL;                    
            $this->mail->Password   = PASSMAIL;                               
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port       = 465;                                    
            $this->mail->CharSet = 'utf-8';
            $this->mail->SMTPOptions = array(
               'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
                ) 
            );
        
            //Recipients
            $this->mail->setFrom('suporte@ivici.com.br', 'Suporte ivici');
            $this->mail->addAddress($email, $nome);     
            /*$this->mail->addAddress('ellen@example.com');               //Name is optional
            $this->mail->addReplyTo('info@example.com', 'Information');
            $this->mail->addCC('cc@example.com');
            $this->mail->addBCC('bcc@example.com');*/
        
            //Attachments
            //$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            //$this->mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $assunto;
            $this->mail->Body    = $corpo;
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            if(!$this->mail->send()){
                $this->Validate->setError("Email não enviado");
                return false;
            }else{
                $this->Validate->setMessage("Email enviado");
                return true;
            }
            
            
        } catch (Exception $e) {
            $erro=$this->mail->ErrorInfo;
            $this->Validate->setError("Email não enviado: {$erro}");
            /*echo "Message could not be sent. Mailer Error: {$erro}";*/
            return false;
        }
    }

    function sendMailExtrato($email,$nome,$assunto,$corpo,$arquivo,$nomeArquivo){
        try {
            //Server settings
            //$this->mail->SMTPDebug  = SMTP::DEBUG_SERVER;                      
            $this->mail->isSMTP();
            $this->mail->SMTPAuth   = true; 
            $this->mail->Host       = HOSTMAILEXTRATO;                     
            $this->mail->Username   = USERMAILEXTRATO;                    
            $this->mail->Password   = PASSMAILEXTRATO;                               
            $this->mail->SMTPSecure = 'ssl';
            $this->mail->Port       = 465;                                    
            $this->mail->CharSet = 'utf-8';
            $this->mail->SMTPOptions = array(
               'ssl' => array( 
                'verify_peer' => false, 
                'verify_peer_name' => false, 
                'allow_self_signed' => true 
                ) 
            );
        
            //Recipients
            $this->mail->setFrom('contabilidade.extrato@ivici.com.br', 'Envio de Extratos ivici!!');
            $this->mail->addAddress($email, $nome);     
            /*$this->mail->addAddress('ellen@example.com');               //Name is optional
            $this->mail->addReplyTo('info@example.com', 'Information');
            $this->mail->addCC('cc@example.com');
            $this->mail->addBCC('bcc@example.com');*/
        
            //Attachments
            //$this->mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
            $this->mail->addAttachment($arquivo, $nomeArquivo);    //Optional name
        
            //Content
            $this->mail->isHTML(true);                                  //Set email format to HTML
            $this->mail->Subject = $assunto;
            $this->mail->Body    = $corpo;
            //$this->mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
            if(!$this->mail->send()){
                $this->Validate->setError("Email não enviado");
                return false;
            }else{
                $this->Validate->setMessage("Email enviado");
                return true;
            }
            
            
        } catch (Exception $e) {
            $erro=$this->mail->ErrorInfo;
            $this->Validate->setError("Email não enviado: {$erro}");
            /*echo "Message could not be sent. Mailer Error: {$erro}";*/
            return false;
        }
    }
}
?>