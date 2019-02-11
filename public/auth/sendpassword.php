<?php
require_once '../set_env.inc.php';
require_once '../menu.inc.php';

$mail_subject = 'Новый пароль на сайте math.ru';
$mail_body = "Здравствуйте!

Ваш логин на сайте math.ru:
%s
Новый пароль:
%s
";

$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/plain; charset=cp1251' . "\r\n";

function gen_rand_string($hash)
{
    $chars = array( 'a', 'A', 'b', 'B', 'c', 'C', 'd', 'D', 'e', 'E', 'f', 'F', 'g', 'G', 'h', 'H', 'i', 'I', 'j', 'J',  'k', 'K', 'l', 'L', 'm', 'M', 'n', 'N', 'o', 'O', 'p', 'P', 'q', 'Q', 'r', 'R', 's', 'S', 't', 'T',  'u', 'U', 'v', 'V', 'w', 'W', 'x', 'X', 'y', 'Y', 'z', 'Z', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0');
    
    $max_chars = count($chars) - 1;
    srand( (double) microtime()*1000000);
    
    $rand_str = '';
    for($i = 0; $i < 8; $i++)
    {
        $rand_str = ( $i == 0 ) ? $chars[rand(0, $max_chars)] : $rand_str . $chars[rand(0, $max_chars)];
    }

    return ( $hash ) ? md5($rand_str) : $rand_str;
}

if ($_POST['sendpassword'])
{
    if (!empty($_POST['email']))
    {
        $sql ="
			SELECT 
				login
			FROM 
				user
			WHERE 
				email = '". addslashes($_POST['email']) . "'";
        if ($login = $_ADODB->GetOne($sql))
        {
            $new_password = gen_rand_string(false);
            $sql = "
				UPDATE 
					user 
				SET 
					password = MD5('" . $new_password . "') 
				WHERE 
					login = '" . $login . "'
				LIMIT 1";
            $_ADODB->Execute($sql);

			$mail_sent = mail(
				$_POST['email'], 
				$mail_subject, 
				sprintf($mail_body, $login, $new_password), 
				$headers
			);
			
			if ($mail_sent) {
	            $_SMARTY->assign('message', 'Новый пароль был выслан на email ' . $_POST['email']);
			} else {
				$_SMARTY->assign('error_message', array('Произошла ошибка при отправке пароля. Пожалуйста, попробуйте позже.'));
			}
        }
        else
        {
            $_SMARTY->assign('error_message', array('Пользователя с таким email не существует'));
        }
    } else {
        $_SMARTY->assign('error_message', array('Вы не указали email'));
    }
}
$_SMARTY->display('auth/sendpassword.tpl');
?>