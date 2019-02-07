{include file="header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file=menu.tpl}
</td>
<td id=content valign=top align=center><div>
{include file="admin/message.tpl"}
<h1>Выслать новый пароль на email</h1>
<form method=post action=/auth/sendpassword.php name=sendpassword>

<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>
<table width=100% cellpadding=5>
<colgroup width=300><colgroup width="*">
<tr><td align=right class=tbldata1>Введите email, указаный при регистрации.</td><td>
<input type=text size=30 name=email>

</td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td align=right><br><input type=submit style="width:200px;" name=sendpassword value="Выслать пароль"></td></tr>
</table>

<a href="/auth/login.php" class=alink>Вход</a><br/>
<a href="/auth/register.php" class=alink>Регистрация</a><br/>

</form>

</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}