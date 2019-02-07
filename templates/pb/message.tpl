<table align="center" width="99%" border="0" cellpadding="0" cellspacing="0" bgcolor="#0078c0">
<tr><td>
<table align="center" width="100%" border="0" cellpadding="2" cellspacing="1">
<form method="post" action="">
<tr bgcolor="white"><td width="100%">
{if $error_message}<span class="error">{section name=i loop=$error_message}Ошибка: {$error_message[i]}<br/>{/section}</span><hr size="1" noshade="noshade"/>{/if}
Отправить сообщение:<br/>
<textarea name="text" rows="4" cols="80" class="wide"></textarea><br/>
<table width="100%"><tr valign="top"><td width="50%">
<b>Ваш e-mail:</b><br/>
<input type="text" name="email" value="" class="wide"/>
</td><td width="50%">
Ваше имя:<br/><input type="text" name="name" value="" class="wide"/>
</td></tr></table>
<!-- <input type="checkbox" name="showemail" value="1"/>&nbsp;показывать e-mail рядом с вашими мнениями<br>-->
<input type="submit" name="do_it" value="отправить" class="wide"/>
</td></tr>
</form>
{section loop=$message name=m}
<tr bgcolor="white"><td>
<b>{$message[m].time} {if $message[m].email}<a href="mailto:{$message[m].email}">{$message[m].name}</a>{else}{$message[m].name}{/if}</b><br/>
{$message[m].text|nl2br}<br/><br/></td></tr>
{/section}
</table></td></tr></table>