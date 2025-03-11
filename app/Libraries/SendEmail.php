<?php

/**
* --------------------------------------------------------------------
* CODEIGNITER 4 - EmailSender
* --------------------------------------------------------------------
*
* This content is released under the MIT License (MIT)
*
* @package    EmailSender
* @author     GeekLabs <geeklabsonline@gmail.com>
* @license    https://opensource.org/licenses/MIT	MIT License
* @link       https://github.com/GeekLabsUK/SimpleAuth
* @since      Version 1.0
* @category   PHP
* @php        7.3
*
*/

namespace App\Libraries;

/**
 * SendEmail
 */
class SendEmail
{
    protected $error;
    /**
     * build
     *
     * @param  mixed $emaildata
     * @return void
     */
    
    public function build($emaildata)
{
    // Assuming $emaildata['message_view'] and $emaildata['messagedata'] are correctly set up
    // Generate the email message using a view
    $message = view('emails/'.$emaildata['message_view'], $emaildata['messagedata']);

    // Prepare additional options (if any), such as reply_to, cc, bcc, and attachments
    $options = [];
    if (isset($emaildata['reply_to'])) {
        $options['reply_to'] = $emaildata['reply_to'];
    }
    if (isset($emaildata['cc'])) {
        $options['cc'] = $emaildata['cc'];
    }
    if (isset($emaildata['bcc'])) {
        $options['bcc'] = $emaildata['bcc'];
    }
    if (isset($emaildata['attachments'])) {
        $options['attachments'] = $emaildata['attachments']; // Ensure this is an array of ['file_path' => ..., 'file_name' => ...]
    }

    // Note: The 'fromEmail' and 'fromName' fields in $emaildata are not directly used in send_app_mail,
    // as send_app_mail uses settings from your application's configuration.
    // Ensure your general helper function or your application's email configuration is set up to handle 'from' address/name correctly.

    // Use the send_app_mail function from the general helper
    $success = send_app_mail($emaildata['to'], $emaildata['subject'], $message, $options);

    if (!$success) {
        $this->error = 'email not sent';
        return false;
    }

    return true;
}


   
}
