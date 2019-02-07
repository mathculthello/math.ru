{include file="header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file=menu.tpl}
</td>
<td id=content valign=top align=center><div>
{include file="generic/message.tpl"}
<h1>Персональная информация</h1>

Дорогие коллеги!
<br>
<p>
Вы можете не вводить информацию о себе. Однако, создавая сообщество, 
хочется понимать кто в нем участвует. Информация будет очень полезна для проведения опросов, 
для работы учительского раздела и других проектов (в частности, возможно, по поддержке учителей).
Введенная информация никогда не попадет в Минобр и никогда не будет использоваться для сравнительно-репресивных целей.
</p>

<form method=post action=/auth/profile.php name=profile>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>
<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Логин:</td><td class=tbldata2>{$_user_login}</td></tr>
<tr><td align=right class=tbldata1>Категория:</td><td class=tbldata2>Учитель</td></tr>
<tr><td align=right class=tbldata1>Email:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small>Email будет использован для восстановления забытого пароля.</div></td><td>
<input type=text size=30 name=email value="{$_user_email}"></td></tr>
</td></tr>
<tr><td align=right class=tbldata1>Пароль:<div class=small>Введите, если хотите сменить пароль или email.</div></td><td>
<input type=password size=30 name=password></td></tr>
<tr><td align=right class=tbldata1>Новый пароль:<div class=small>Введите, если хотите сменить пароль.</div></td><td>
<input type=password size=30 name=newpassword></td></tr>
<tr><td align=right class=tbldata1>Подтверждение пароля:<div class=small align=right>Введите еще раз новый пароль.</div></td><td>
<input type=password size=30 name=newpassword2></td></tr>
<tr><td align=right class=tbldata1>Фамилия:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=lname value="{$_user_lname}"></td></tr>
<tr><td align=right class=tbldata1>Имя:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=fname value="{$_user_fname}"></td></tr>
<tr><td align=right class=tbldata1>Отчество:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=sname value="{$_user_sname}"></td></tr>
<tr><td align=right class=tbldata1>Страна:</td><td>
<input type=text size=30 name=country value="{$_user_country}"></td></tr>
<tr><td align=right class=tbldata1>Регион:</td><td>
<input type=text size=30 name=region value="{$_user_region}"></td></tr>
<tr><td align=right class=tbldata1>Город:</td><td>
<input type=text size=30 name=city value="{$_user_city}"></td></tr>
<tr><td align=right class=tbldata1>Округ:</td><td>
<input type=text size=30 name=district value="{$_user_district}"></td></tr>
<tr><td align=right class=tbldata1>Школа:</td><td>
<input type=text size=30 name=school value="{$_user_school}"></td></tr>
<tr><td align=right class=tbldata1>Специализация школы:</td><td>
<input type=text size=30 name=school_profile value="{$_user_school_profile}"></td></tr>
<tr><td align=right class=tbldata1>Какие предметы Вы преподаете:</td><td>
<input type=text size=30 name=subj value="{$_user_subj}"></td></tr>
</table></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="01"></td></tr>
<tr><td align=right><input type=submit name=change value="Изменить"></td>
</table>
<br>

</form>

</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}