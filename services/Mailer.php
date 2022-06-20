<?php

namespace app\services;

use app\base\Request;
class Mailer extends Request{

    private $subject_to;
    private $message;
    public function checkForm() {
        if (!empty($this->subject_to)) {
            return true;
        } else {
            return false;
        }
    }

    public function sendEmail() {
        if ($this->checkForm()) {

            $params = $this->post();
            $this->subject_to = $params['email'];
            $this->message = "Text message";
            mail($this->subject_to, "Тема письма", wordwrap($this->message));
            echo "<p>Email Send Success</p>";
            
        } else {
            echo "<p>Error Email Send</p>";
        }
    }
}
