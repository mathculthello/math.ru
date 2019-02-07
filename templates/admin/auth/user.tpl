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

<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} пользователя</td></tr>
</table>
{include file="message.tpl"}
<br/>

<form name=user enctype="multipart/form-data" action="/admin/auth/user.php" method=post>

<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Логин</td><td><input type=text size=80 name=login value="{$login}"></td></tr>
<tr><td class=tblheader1 valign=top>Пароль</td><td><input type=password size=30 name=new_password value="{$new_password}"></td></tr>
<tr><td class=tblheader1 valign=top>Подтверждение пароля</td><td><input type=password size=30 name=new_password2 value="{$new_password2}"></td></tr>
<tr><td class=tblheader1 valign=top>Email</td><td><input type=text size=80 name=email value="{$email}"></td></tr>
<tr><td class=tblheader1 valign=top>Фамилия</td><td><input type=text size=80 name=lname value="{$lname}"></td></tr>
<tr><td class=tblheader1 valign=top>Имя</td><td><input type=text size=80 name=fname value="{$fname}"></td></tr>
<tr><td class=tblheader1 valign=top>Отчество</td><td><input type=text size=80 name=sname value="{$sname}"></td></tr>
<tr><td class=tblheader1 valign=top>Категория</td><td>
<select name="profile" onchange="selectProfile(this[this.selectedIndex].value);">
{html_options options=$profile_options selected=$profile}
</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Статус</td><td>
<select name="status">
{html_options options=$status_options selected=$status}
</select>
</td></tr>

<tr><td class=tblheader1>Страна:</td><td>
<input type=text size=30 name=country value="{$country}"></td></tr>
<tr><td class=tblheader1>Регион:</td><td>
<input type=text size=30 name=region value="{$region}"></td></tr>
<tr><td class=tblheader1>Город:</td><td>
<input type=text size=30 name=city value="{$city}"></td></tr>
</table>

<span style='background-color:#F2F2F2;display:{if $profile == "student" || !$profile}block{else}none{/if};' id='profile_student'>
<table width=100%>
<colgroup width=300><colgroup width="*">
<tr><td class=tblheader1>Школа:</td><td>
<input type=text size=30 name=school value="{$school}"></td></tr>
<tr><td class=tblheader1>Специализация класса:</td><td>
<input type=text size=30 name=form_profile value="{$form_profile}"></td></tr>
<tr><td class=tblheader1>Номер класса:</td><td>
<input type=text size=30 name=form value="{$form}"></td></tr>
</table>
</span>

<span style='background-color:#F2F2F2;display:{if $profile == "teacher"}block{else}none{/if};' id='profile_teacher'>
<table width=100%>
<colgroup width=300><colgroup width="*">
<tr><td class=tblheader1>Округ:</td><td>
<input type=text size=30 name=district value="{$district}"></td></tr>
<tr><td class=tblheader1>Школа:</td><td>
<input type=text size=30 name=school value="{$school}"></td></tr>
<tr><td class=tblheader1>Специализация школы:</td><td>
<input type=text size=30 name=school_profile value="{$school_profile}"></td></tr>
<tr><td class=tblheader1>Предметы:</td><td>
<input type=text size=30 name=subj value="{$subj}"></td></tr>
</table>
</span>



<hr>
<div align=right>
<input type=submit name=save value="Сохранить">
{if $id}<input type=submit onclick="return confirm('Удалить пользователя?');" name=delete value="Удалить"/>{/if}
<input type="button" onclick="window.location='/admin/auth/user_list.php'" value="К списку"/>
</div>

<input type=hidden name=id value={$id}>
<input type=hidden name=user value=1>
</form>
{include file="footer.tpl"}