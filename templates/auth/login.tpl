{include file="header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file=menu.tpl}
</td>
<td id=content valign=top align=center><div>
{include file="generic/message.tpl"}
<h1>Вход для зарегистрированных пользователей</h1>
<form method=post action=/auth/login.php name=login>

<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>
<table width=100% cellpadding=5>
<colgroup width=400><colgroup width="*">
<tr><td align=right class=tbldata1>Имя:</td><td>
<input type=text size=30 name=login></td></tr>
<tr><td align=right class=tbldata1>Пароль:</td><td>
<input type=password size=30 name=password></td></tr>
<tr><td align=right class=tbldata1>Автоматически входить при каждом посещении:</td><td>
<input type=checkbox name=remember></td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td align=right><br><input type=submit style="width:200px;" name=loginbtn value="Вход"></td></tr>
</table>

<input type=hidden name=redirect value={$_redirect|default:"/auth/profile.php"}>

<a href="/auth/sendpassword.php" class=alink>Забыли пароль?</a><br/>
<a href="/auth/register.php" class=alink>Регистрация</a><br/>

</form>

</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}