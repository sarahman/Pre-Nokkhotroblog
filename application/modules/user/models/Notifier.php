
 <?php

class User_Model_Notifier
{
    public function sendRegistrationEmail($data )
    {
        $emailManager       = new Speed_Library_EmailManager();

        $emailData = array();

        $emailData['to']              = $data['email_address'];
        $emailData['to_name']         = $data['username'];
        $emailData['reply_to_name']   = 'Registration';
        $emailData['subject']         = 'Registration for Nokkhotro Blog';
        $emailData['activation_code'] = $data['activation_code'];
        $emailData['user_id']         = $data['user_id'];


        $emailManager->send('register',$emailData['subject'],$emailData['to'],$emailData['to_name'],$emailData);

    }
}
