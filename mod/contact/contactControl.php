<?php


class contactControl extends Control {

    public function __construct() {
        parent::__construct();
    }


    public function send() {

        $post = $this->getPost();

        if (!$this->validatePost('nome','email','message'))
            $this->commitReplace('Hey, informe os campos acima!', '#mailmsg', false);

        require_once LIBDIR . '/class.phpmailer.php';
        require_once LIBDIR . '/class.smtp.php';
        $mail = new PHPMailer();

        $mail->isSMTP();

        $mail->CharSet = 'utf-8';
        $mail->isHTML(true);
        $mail->SMTPDebug = 0;
        $mail->Port = 587;
        $mail->Host = 'smtp.mandrillapp.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'elvis.vista@gmail.com';
        $mail->Password = 'rcHj5EqQRCprgAiBqWLb8g';
        $mail->FromName = $post['nome'];
        $mail->From = $post['email'];
        $mail->addReplyTo($post['email']);

        $mail->Subject = 'Contato elvis.gravi.com.br: ' . $post['nome'];
        $mail->Body =
            'Page: elvis.gravi.com.br' .
            'Fone: ' . $post['phone'] . PHP_EOL .
            'Mensagem: ' . $post['message'];

        $mail->addAddress('elvis@gravi.com.br');

        $this->model()->saveContact($post);

        if ($mail->send()) {
            $this->commitHide('#sendmail');
            $this->commitReplace('I will reach you out soon. Thank you!', '#mailmsg');
        }
        else
            $this->commitReplace('Your contact is saved and I will get back to you soon. Thank you!', '#mailmsg');


    }

    private function getLnMessage() {

        $message = 'I will reach you out soon. Thank you!';
        $ln = Session::get('ln');
        !in_array($ln, array('en', 'pt')) || $message = 'Estarei lhe retornando em breve. Obrigado!';

        return $message;
    }

}