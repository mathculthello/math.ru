{include file="header.tpl"}
{literal}
<script language='javascript'>
function selectProfile(profile) {
var oElement = null;
if (profile == 'student') {
	oElement = document.getElementById('profile_student');
	oElement.style.display = 'block';
	oElement = document.getElementById('profile_teacher');
	oElement.style.display = 'none';
	oElement = document.getElementById('message_teacher');
	oElement.style.display = 'none';
} else if (profile == 'teacher') {
	oElement = document.getElementById('profile_student');
	oElement.style.display = 'none';
	oElement = document.getElementById('profile_teacher');
	oElement.style.display = 'block';
	oElement = document.getElementById('message_teacher');
	oElement.style.display = 'block';
} else {
	oElement = document.getElementById('profile_student');
	oElement.style.display = 'none';
	oElement = document.getElementById('profile_teacher');
	oElement.style.display = 'none';
	oElement = document.getElementById('message_teacher');
	oElement.style.display = 'none';
}
document.body.focus();
}
</script>
{/literal}

<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file=menu.tpl}
</td>
<td id=content valign=top align=center><div>
{include file="generic/message.tpl"}
<h1>Регистрация нового пользователя</h1>

<span style='background-color:#F2F2F2;display:{if $profile == "teacher"}block{else}none{/if};' id='message_teacher'>
Дорогие коллеги!
<br>
<p>
Вы можете не вводить информацию о себе. Однако, создавая сообщество, 
хочется понимать кто в нем участвует. Информация будет очень полезна для проведения опросов, 
для работы учительского раздела и других проектов (в частности, возможно, по поддержке учителей).
Введенная информация никогда не попадет в Минобр и никогда не будет использоваться для сравнительно-репресивных целей.
</p>
</span>

<form method=post action=/auth/register.php name=register>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>

<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Логин:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><input type=text size=30 name="newlogin" value="{$newlogin}"></td></tr>
<tr><td align=right class=tbldata1>Категория:</td><td class=tbldata2>
<select name=profile onchange="selectProfile(this[this.selectedIndex].value);">
<option value="student"{if $profile == "student" || !$profile} selected=selected{/if}>Ученик</option>
<option value="teacher"{if $profile == "teacher"} selected=selected{/if}>Учитель</option>
<option value="parent"{if $profile == "parent"} selected=selected{/if}>Родитель</option>
<option value="other"{if $profile == "other"} selected=selected{/if}>Другое</option>
</select>
</td></tr>
<tr><td align=right class=tbldata1>Email:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small>Email будет использован для восстановления забытого пароля.</div></td><td>
<input type=text size=30 name=email value="{$email}"></td></tr>
<tr><td align=right class=tbldata1>Пароль:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=password size=30 name=password></td></tr>
<tr><td align=right class=tbldata1>Подтверждение пароля:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small align=right>Введите еще раз новый пароль.</div></td><td>
<input type=password size=30 name=password2></td></tr>
<tr><td align=right class=tbldata1>Фамилия:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=lname value="{$lname}"></td></tr>
<tr><td align=right class=tbldata1>Имя:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=fname value="{$fname}"></td></tr>
<tr><td align=right class=tbldata1>Отчество:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name=sname value="{$sname}"></td></tr>
<tr><td align=right class=tbldata1>Страна:</td><td>
<input type=text size=30 name=country value="{$country}"></td></tr>
<tr><td align=right class=tbldata1>Регион:</td><td>
<input type=text size=30 name=region value="{$region}"></td></tr>
<tr><td align=right class=tbldata1>Город:</td><td>
<input type=text size=30 name=city value="{$city}"></td></tr>
</table>

<span style='background-color:#F2F2F2;display:{if $profile == "student" || !$profile}block{else}none{/if};' id='profile_student'>
<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Школа:</td><td>
<input type=text size=30 name=school value="{$school}"></td></tr>
<tr><td align=right class=tbldata1>Специализация класса:</td><td>
<input type=text size=30 name=form_profile value="{$form_profile}"></td></tr>
<tr><td align=right class=tbldata1>Номер класса:</td><td>
<input type=text size=30 name=form value="{$form}"></td></tr>
</table>
</span>

<span style='background-color:#F2F2F2;display:{if $profile == "teacher"}block{else}none{/if};' id='profile_teacher'>
<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Округ:</td><td>
<input type=text size=30 name=district value="{$district}"></td></tr>
<tr><td align=right class=tbldata1>Школа:</td><td>
<input type=text size=30 name=school value="{$school}"></td></tr>
<tr><td align=right class=tbldata1>Специализация школы:</td><td>
<input type=text size=30 name=school_profile value="{$school_profile}"></td></tr>
<tr><td align=right class=tbldata1>Какие предметы Вы преподаете:</td><td>
<input type=text size=30 name=subj value="{$subj}"></td></tr>
</table>
</span>

</td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="01"></td></tr>
<tr><td align=right><input type=submit name=register value="Зарегистрироваться"></td>
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