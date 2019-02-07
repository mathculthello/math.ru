{include file="header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file=menu.tpl}
</td>
<td id=content valign=top align=center><div>
{include file="generic/message.tpl"}
<h1>Регистрация нового пользователя</h1>

<form method=post action=/auth/register.php name=register>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>
<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Категория:</td><td class=tbldata2>
<select name=profile>
<option value='student'{if $_user_profile == 'student'} selected{/if}>Ученик</option>
<option value='teacher'{if $_user_profile == 'teacher'} selected{/if}>Учитель</option>
<option value='parent'{if $_user_profile == 'parent'} selected{/if}>Родитель</option>
<option value='other'{if $_user_profile == 'other'} selected{/if}>Другое</option>
</select>
</td></tr>
</table></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="01"></td></tr>
<tr><td align=right><input type=submit name=choose_profile value="Продолжить регистрацию"></td>
</table>
<br>
<a href="/auth/sendpassword.php" class=alink>Забыли пароль?</a><br/>
<a href="/auth/login.php" class=alink>Вход</a><br/>

</form>

</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}