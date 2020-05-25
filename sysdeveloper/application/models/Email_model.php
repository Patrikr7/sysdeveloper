<?php

class Email_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('phpmailer_lib');
    }

    // ENIVO PARA RECUPERAR SENHA
    public function ForgotPassword($email)
    {
        $link = base_url("admin/redefine-password/{$email['user_uuid']}");

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = getenv('MAIL_HOST');
        $mail->Username   = getenv('MAIL_USER');
        $mail->Password   = getenv('MAIL_PASS');
        $mail->Port       = intval(getenv('MAIL_PORT'));

        $mail->setFrom(getenv('MAIL_USER'), "Sistema - " . getenv('SIS_NAME'));
        $mail->addReplyTo(getenv('MAIL_USER'), "Sistema - " . getenv('SIS_NAME'));

        // Add a recipient
        $mail->addAddress($email['user_email'], $email["user_name"]);

        // Email subject
        $mail->Subject = 'Redefinir senha';

        // Charset
        $mail->CharSet = 'utf-8';

        //Language
        $mail->SetLanguage('pt-Br');


        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "
        <div style=\"margin:0;padding:0;background-color:#f0f0f0;\">
            <div style=\"background-color:#f0f0f0; padding:5px;\">
                <div style=\"font-size:10px;line-height:10px\">&nbsp;</div>
                <table style=\"border-collapse:collapse;table-layout:fixed; margin: 20px auto 0;word-wrap:break-word;word-break:break-word;background-color:#ffffff\" align=\"center\">
                    <tbody>
                        <tr>
                            <td style=\"padding:0;text-align:left;vertical-align:top;color:#787778;font-size:14px;line-height:21px;font-family:Ubuntu,sans-serif;width:600px\">
                                <div style=\"Margin-left:20px;Margin-right:20px;Margin-top:24px\">
                                    <div style=\"line-height:20px;font-size:1px\">&nbsp;</div>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <h1 style=\"Margin-top:0;Margin-bottom:0;font-style:normal;font-weight:normal;color:#565656;font-size:36px;line-height:43px;text-align:center\">
                                        <strong>Redefinir Senha</strong>
                                    </h1>
                                    <p>Olá, <b>{$email['user_name']}!</b>.<br/></p>
                                    <p style=\"background-color: #eeeeee; padding: 15px; position: relative; left: -15px;\">
                                        Para garantir uma boa prática de que você realmente pediu para redefinir a senha acesse o link abaixo, pedimos que todos os usuários confirmem a titularidade do e-mail. Assim evitamos enviar mensagens para alguém que não queira recebê-las. <br>
                                        Clique no <b>LINK</b> abaixo para <b>REDEFINIR A SENHA</b>.
                                    </p>
                                    <br/>
                                    <a href=\"{$link}\" style=\"font-family:'Arial',sans-serif; font-size: 17px; background-color: #5cb85c; padding: 15px; color: #FFFFFF; text-decoration: none;\">REDEFINIR A SENHA</a>
                                    <br/>
                                    <br/>
                                    <p>Este e-mail é enviado pelo sistema, por favor não o responda.<br/>Qualquer dúvida entre em contato pelo e-mail <b>" . getenv('MAIL_SUPORTE') . "</b>.</p>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <div style=\"line-height:10px;font-size:1px\">&nbsp;</div>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <div style=\"line-height:10px;font-size:1px\">&nbsp;</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" bgcolor=\"#e0ddd6\" border=\"0\" style=\"margin-bottom:20px;\">
                    <tbody>
                        <tr>
                            <td width=\"15\"></td>
                            <td>
                                <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" bgcolor=\"#666666\" border=\"0\" style=\"border-bottom-left-radius:4px;border-bottom-right-radius:4px\">
                                    <tbody>
                                        <tr>
                                            <td height=\"14\">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width=\"15\"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ";

        $mail->Body = $mailContent;

        // Send email
        if(!$mail->send()):
            return $mail->ErrorInfo;
        
        else:            
            return true;

        endif;
    }

    // ENIVO PARA REDEFINIR SENHA
    public function RedefinePassword($user, $user_pass)
    {
        $link = base_url("admin/login");

        // PHPMailer object
        $mail = $this->phpmailer_lib->load();

        // SMTP configuration
        $mail->isSMTP();
        $mail->SMTPAuth   = true;
        $mail->Host       = getenv('MAIL_HOST');
        $mail->Username   = getenv('MAIL_USER');
        $mail->Password   = getenv('MAIL_PASS');
        $mail->Port       = intval(getenv('MAIL_PORT'));

        $mail->setFrom(getenv('MAIL_USER'), "Sistema - " . getenv('SIS_NAME'));
        $mail->addReplyTo(getenv('MAIL_USER'), "Sistema - " . getenv('SIS_NAME'));

        // Add a recipient
        $mail->addAddress($user->user_email, $user->user_name);

        // Email subject
        $mail->Subject = 'Senha alterada';

        // Charset
        $mail->CharSet = 'utf-8';

        //Language
        $mail->SetLanguage('pt-Br');


        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mailContent = "
        <div style=\"margin:0;padding:0;background-color:#f0f0f0;\">
            <div style=\"background-color:#f0f0f0; padding:5px;\">
                <div style=\"font-size:10px;line-height:10px\">&nbsp;</div>
                <table style=\"border-collapse:collapse;table-layout:fixed; margin: 20px auto 0;word-wrap:break-word;word-break:break-word;background-color:#ffffff\" align=\"center\">
                    <tbody>
                        <tr>
                            <td style=\"padding:0;text-align:left;vertical-align:top;color:#787778;font-size:14px;line-height:21px;font-family:Ubuntu,sans-serif;width:600px\">
                                <div style=\"Margin-left:20px;Margin-right:20px;Margin-top:24px\">
                                    <div style=\"line-height:20px;font-size:1px\">&nbsp;</div>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <h1 style=\"Margin-top:0;Margin-bottom:0;font-style:normal;font-weight:normal;color:#565656;font-size:36px;line-height:43px;text-align:center\">
                                        <strong>Redefinir Senha</strong>
                                    </h1>
                                    <p>Olá, <b>{$user->user_name}!</b>.<br/></p>
                                    <p style=\"background-color: #eeeeee; padding: 15px; position: relative; left: -15px;\">
                                        Sua senha foi alterada com sucesso. <br>
                                        Clique no <b>LINK</b> abaixo para acessar o painel.
                                    </p>
                                    <br/>
                                    <a href=\"{$link}\" style=\"font-family:'Arial',sans-serif; font-size: 17px; background-color: #5cb85c; padding: 15px; color: #FFFFFF; text-decoration: none;\">PAINEL</a>
                                    <br/>
                                    <br/>
                                    <p>Este e-mail é enviado pelo sistema, por favor não o responda.<br/>Qualquer dúvida entre em contato pelo e-mail <b>" . getenv('MAIL_SUPORTE') . "</b>.</p>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <div style=\"line-height:10px;font-size:1px\">&nbsp;</div>
                                </div>
                                <div style=\"Margin-left:20px;Margin-right:20px\">
                                    <div style=\"line-height:10px;font-size:1px\">&nbsp;</div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" bgcolor=\"#e0ddd6\" border=\"0\" style=\"margin-bottom:20px;\">
                    <tbody>
                        <tr>
                            <td width=\"15\"></td>
                            <td>
                                <table cellpadding=\"0\" cellspacing=\"0\" width=\"600\" align=\"center\" bgcolor=\"#666666\" border=\"0\" style=\"border-bottom-left-radius:4px;border-bottom-right-radius:4px\">
                                    <tbody>
                                        <tr>
                                            <td height=\"14\">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td width=\"15\"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        ";

        $mail->Body = $mailContent;

        $data = [
            'user_pass' => $user_pass,
            'user_cpass' => $user_pass,
            'user_uuid' => $this->uuid->v4(),
            'user_id' => $user->user_id
        ];

        // ATUALIZA SENHA
        if($this->user->updatePassword($data)):
            // Send email
            if(!$mail->send()):
                return $mail->ErrorInfo;
            
            else:            
                return true;

            endif;

        else:
            return 'Erro ao atualizar senha, entre em contato com o suporte.';

        endif;
        
    }
}
