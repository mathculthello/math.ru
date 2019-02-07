{include file="header.tpl"}

<table width=100%>
<tr class="tblheader"><td colspan="2"></td></tr>
</table>

<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Логин</td><td>{$login}</td></tr>
<tr><td class=tblheader1 valign=top>Email</td><td>{$email}</td></tr>
<tr><td class=tblheader1 valign=top>Фамилия</td><td>{$lname}</td></tr>
<tr><td class=tblheader1 valign=top>Имя</td><td>{$fname}</td></tr>
<tr><td class=tblheader1 valign=top>Отчество</td><td>{$sname}</td></tr>
<tr><td class=tblheader1 valign=top>Категория</td><td>
{$profile_options[$profile]}
</td></tr>
<tr><td class=tblheader1 valign=top>Статус</td><td>
{$status_options[$status]}
</td></tr>

<tr><td class=tblheader1>Страна:</td><td>
{$country}</td></tr>
<tr><td class=tblheader1>Регион:</td><td>
{$region}</td></tr>
<tr><td class=tblheader1>Город:</td><td>
{$city}</td></tr>
</table>

<span style='background-color:#F2F2F2;display:{if $profile == "student" || !$profile}block{else}none{/if};' id='profile_student'>
<table width=100%>
<colgroup width=300><colgroup width="*">
<tr><td class=tblheader1>Школа:</td><td>
{$school}</td></tr>
<tr><td class=tblheader1>Специализация класса:</td><td>
{$form_profile}</td></tr>
<tr><td class=tblheader1>Номер класса:</td><td>
{$form}</td></tr>
</table>
</span>

<span style='background-color:#F2F2F2;display:{if $profile == "teacher"}block{else}none{/if};' id='profile_teacher'>
<table width=100%>
<colgroup width=300><colgroup width="*">
<tr><td class=tblheader1>Округ:</td><td>
{$district}</td></tr>
<tr><td class=tblheader1>Школа:</td><td>
{$school}</td></tr>
<tr><td class=tblheader1>Специализация школы:</td><td>
{$school_profile}</td></tr>
<tr><td class=tblheader1>Предметы:</td><td>
{$subj}</td></tr>
</table>
</span>
{include file="footer.tpl"}