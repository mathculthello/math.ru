{include file="header.tpl"}
<table width=100%>
<tr class="tblheader"><td colspan="2">Анкета слушателя курсов МИОО</td></tr>
</table>
<br/>
<form name=article enctype="multipart/form-data" action="/admin/teacher/mioo_user.php" method=post>
<div align=right>
<input type=submit name=save value="Сохранить изменения">
{if $id}<input type=submit onclick="return confirm('Удалить регистрационные данные? (Пользователь сайта не будет удален)');" name=delete value="Удалить"/>{/if}
<input type="button" onclick="window.location='/admin/teacher/mioo_list.php'" value="К списку"/>
</div>
<hr/>
<table align="right"><tr><td><a href="/teacher/courses_print.php?id={$id}">Версия для печати.</a></td></tr></table>

{include file="message.tpl"}
<br/>
{literal}
<script language='javascript'>
function selectDocument(doc) {
var oElement = null;
if (doc == 'passport') {
	oElement = document.getElementById('document_passport');
	oElement.style.display = 'block';
	oElement = document.getElementById('document_intpassport');
	oElement.style.display = 'none';
	oElement = document.getElementById('document_other');
	oElement.style.display = 'none';
} else if (doc == 'intpassport' || doc == 'oficer') {
	oElement = document.getElementById('document_passport');
	oElement.style.display = 'none';
	oElement = document.getElementById('document_intpassport');
	oElement.style.display = 'block';
	oElement = document.getElementById('document_other');
	oElement.style.display = 'none';
} else {
	oElement = document.getElementById('document_passport');
	oElement.style.display = 'none';
	oElement = document.getElementById('document_intpassport');
	oElement.style.display = 'block';
	oElement = document.getElementById('document_other');
	oElement.style.display = 'block';
}
document.body.focus();
}
</script>
{/literal}


<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Пользователь math.ru</td><td>
<a href="javascript:window.open('/admin/auth/user_view.php?id={$id}','user','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus();">{$login}</a>
</td></tr>
<tr><td class=tblheader1 valign=top>Учебный год</td><td>
<select name="sch_year">{html_options options=$year_options selected=$sch_year}</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Шифр курса</td><td>
<select name="course">{html_options options=$course_options selected=$course}</select>
<a href="#" title="Выбрать курс из списка" onclick="popup=window.open('/teacher/course_picker.php','_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
Выбрать курс</a>
</td></tr>
<tr><td class=tblheader valign=top colspan="2">Общие данные</td></tr>
<tr><td class=tblheader1 valign=top>1. Фамилия, имя и<BR>отчество<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<table cellpadding="5"><tr>
<td class="tbldata1">фамилия:&nbsp;</td>
<td><input type=text size=20 name="lname" value="{$lname}"></td>
</tr><tr>
<td class="tbldata1">имя:&nbsp;</td>
<td><input type=text size=20 name="fname" value="{$fname}"></td>
</tr><tr>
<td class="tbldata1">отчество:&nbsp;</td>
<td><input type=text size=20 name="sname" value="{$sname}"></td>
</tr></table>
</td></tr>

<tr><td class=tblheader1 valign=top>2. Документ, удостоверяющий личность<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<select name="document" onchange="selectDocument(this[this.selectedIndex].value);">{html_options options=$document_options selected=$document}</select>
<br/>

<span style='background-color:#F2F2F2;display:{if $document == "passport" || !$document}block{else}none{/if};' id='document_passport'>

<table cellpadding="5"><tr>
<td class="tbldata1">серия:&nbsp;</td>
<td><input type=text size=4 name="passport_ser" value="{$passport_ser}"></td>
</tr>
<tr>
<td class="tbldata1">номер:&nbsp;</td>
<td><input type=text size=6 name="passport_num" value="{$passport_num}"></td>
</tr>
<tr>
<td class="tbldata1">дата выдачи:&nbsp;</td>
<td>
<select name="passport_day">{html_options options=$birthdate_day_options selected=$passport_day}</select>
<select name="passport_month">{html_options options=$birthdate_month_options selected=$passport_month}</select>
<input type=text size=5 name="passport_year" value="{$passport_year}">
</td></tr>
<tr>
<td class="tbldata1">орган выдавший:&nbsp;</td>
<td><input type=text size=20 name="passport_org" value="{$passport_org}"></td>
</tr>
<tr>
<td class="tbldata1">код подразделения:&nbsp;</td>
<td>
<input type=text size=3 name="passport_orgcode1" value="{$passport_orgcode1}">&nbsp;-&nbsp;<input type=text size=3 name="passport_orgcode2" value="{$passport_orgcode2}">
</td>
</tr>
<tr>
<td class="tbldata1">название подразделения:&nbsp;</td>
<td><input type=text size=20 name="passport_orgname" value="{$passport_orgname}"></td>
</tr>
</table>
</span>

<span style='background-color:#F2F2F2;display:{if $document == "intpassport" || $document == "oficer" || $document == "other" }block{else}none{/if};' id='document_intpassport'>
<table cellpadding="5">
<tr style='background-color:#F2F2F2;display:{if $document == "other"}block{else}none{/if};' id='document_other'>
<td class="tbldata1">тип документа:&nbsp;</td>
<td><input type=text size=20 name="passport_type" value="{$passport_type}"></td>
</tr>
<tr>
<td class="tbldata1">серия и  номер:&nbsp;</td>
<td><input type=text size=20 name="passport_sernum" value="{$passport_sernum}"></td>
</tr>
<tr>
<td class="tbldata1">орган выдавший:&nbsp;</td>
<td><input type=text size=20 name="passport_other_org" value="{$passport_other_org}"></td>
</tr>
<tr>
<td class="tbldata1">дата выдачи:&nbsp;</td>
<td>
<select name="passport_other_day">{html_options options=$birthdate_day_options selected=$passport_other_day}</select>
<select name="passport_other_month">{html_options options=$birthdate_month_options selected=$passport_other_month}</select>
<input type=text size=5 name="passport_other_year" value="{$passport_other_year}">
</td></tr>
</table>
</span>

</td></tr>
<tr><td class=tblheader1 valign=top>3. Дата рождения<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<select name="birthdate_day">{html_options options=$birthdate_day_options selected=$birthdate_day}</select>
<select name="birthdate_month">{html_options options=$birthdate_month_options selected=$birthdate_month}</select>
<input type=text size=5 name="birthdate_year" value="{$birthdate_year}">
</td></tr>
<tr><td class=tblheader1 valign=top>
4. Пол<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a>
</td><td>
<select name="sex"><option value="m"{if $sex == 'm'} selected="selected"{/if}>М</option><option value="w"{if $sex == 'w'} selected="selected"{/if}>Ж</option></select>
</td></tr>
<tr><td class=tblheader1 valign=top>5. Образование<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<select name="edu">
<option value="high"{if $edu == 'high'} selected="selected"{/if}>высшее</option>
<option value="high1"{if $edu == 'high1'} selected="selected"{/if}>неполное высшее</option>
<option value="col"{if $edu == 'col'} selected="selected"{/if}>среднее специальное</option>
</select></td></tr>
<tr><td class=tblheader1 valign=top>6. Когда и какое учебное заведение окончил(а)<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=60 name="edu_school" value="{$edu_school}">
</td></tr>
<tr><td class=tblheader1 valign=top>7. Специальность по диплому<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name="edu_spec" value="{$edu_spec}">
</td></tr>
<tr><td class=tblheader1 valign=top>8. Квалификация по диплому<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=30 name="edu_qual" value="{$edu_qual}">
</td></tr>
<tr><td class=tblheader valign=top colspan="2">Данные о месте работы</td></tr>

<tr><td class=tblheader1 valign=top>1. Место работы (обр. учреждение) <a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<table cellpadding="5"><tr>
<td class="tbldata1">тип:&nbsp;</td>
<td>
<select name="school_type">
<option value="school" {if $school_type == "school" || !$school_type} selected=selected{/if}>Школа</option>
<option value="liceum"{if $school_type == "liceum"} selected=selected{/if}>Лицей</option>
<option value="high"{if $school_type == "high"} selected=selected{/if}>Гимназия</option>
<option value="uvk"{if $school_type == "uvk"} selected=selected{/if}>УВК</option>
</select>
</td>
</tr><tr>
<td class="tbldata1">номер:&nbsp;</td>
<td><input type=text size=5 name=school_num value="{$school_num}">  (четырехзначное число,<BR>например, <I>0789, 1303, 1547</I>)</td>
</tr><tr>
<td class="tbldata1">полное название:&nbsp;</td><td><input type=text size=30 name="school_name" value="{$school_name}"></td>
</tr></table>
</td></tr>
<tr><td class=tblheader1 valign=top>2. Адрес образовательного учреждения и округ<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<table cellpadding="5"><tr>
<td class="tbldata1">индекс:&nbsp;</td>
<td><input type="text" size="7" name="school_addr_zip" value="{$school_addr_zip}"></td>
<td class="tbldata1">город:&nbsp;</td>
<td><input type="text" size="10" name="school_addr_city" value="{$school_addr_city}"></td>
</tr><tr>
<td class="tbldata1">адрес:&nbsp;</td>
<td><input type="text" size="10" name="school_addr_txt" value="{$school_addr_txt}"></td>
<td class="tbldata1">округ:&nbsp;</td>
<td>
<select name="school_addr_dist">
{html_options options=$dist_options selected=$school_addr_dist}
</select>
</td></tr></table>
</td></tr>
<tr><td class=tblheader1 valign=top>3. Должность и дата назначения<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=60 name=school_pos value="{$school_pos}"></td></tr>
<tr><td class=tblheader1 valign=top>4. Стаж педагогический<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=5 name=school_exp_teacher value="{$school_exp_teacher}">&nbsp;полных лет
</td></tr>
<tr><td class=tblheader1 valign=top>5. Стаж руководящей работы</td><td>
<input type=text size=5 name=school_exp_director value="{$school_exp_director}">&nbsp;полных лет</td></tr>
<tr><td class=tblheader1 valign=top>6. Квалификационная категория<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<table cellpadding="5"><tr>
<td class=tbldata1>разряд</td><td><input type=text size=4 name=school_cat_num value="{$school_cat_num}"></td>
<td class="tbldata1">год и место присвоения</td><td><input type=text size=30 name=school_cat value="{$school_cat}"></td>
</tr></table>
</td></tr>
<tr><td class=tblheader1 valign=top>7. Повышение квалификации.</td><td>
<table>
<tr><td colspan="2" class="tbldata1">Последнее повышение квалификации</td></tr>
<tr><td class="tbldata1">Тема курса, количество часов</td><td><input type="text" size="30" name="school_lastcourse_subj" value="{$school_lastcourse_subj}"></td></tr>
<tr><td class="tbldata1">Даты прохождения курса (с…по...)</td><td><input type="text" size="30" name="school_lastcourse_period" value="{$school_lastcourse_period}"></td></tr>
<tr><td class="tbldata1">Место прохождения</td><td><input type="text" size="30" name="school_lastcourse_place" value="{$school_lastcourse_place}"></td></tr>
<tr><td class="tbldata1">Документ-основание<br>(удостоверение, свидетельство, зачетная книжка, № документа)</td><td><input type="text" size="30" name="school_lastcourse_doc" value="{$school_lastcourse_doc}"></td></tr>
</table>
</td></tr>
<tr><td class=tblheader1 valign=top>8. Если Вы закончили какие-либо другие дополнительные курсы повышения квалификации, укажите их</td><td>
<textarea name="school_courses" cols="30">
{$school_courses}
</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>9. Тема методической работы</td><td>
<textarea name="school_met" cols="30">
{$school_met}
</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>10. Тема экспериментальной работы (если таковая ведется)</td><td>
<textarea name="school_exp" cols="30">
{$school_exp}
</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>11. Участие в методической работе (наставник, разработчик, эксперт, иное, укажите что именно)</td><td>
<textarea name="school_met_role" cols="30">
{$school_met_role}
</textarea>
</td></tr>
<tr><td class=tblheader valign=top colspan="2">Дополнительная информация</td></tr>
<tr><td class=tblheader1 valign=top>1. Телефон</td><td>
<table cellpadding="5"><tr>
<td class=tbldata1>домашний</td><td>
(<input type="text" size="3" name="contact_code" value="{$contact_code}">)
<input type="text" size="9" name="contact_phone" value="{$contact_phone}"></td>
</tr><tr>
<td class=tbldata1>рабочий</td><td>
(<input type="text" size="3" name="work_code" value="{$work_code}">)
<input type="text" size="9" name="work_phone" value="{$work_phone}"></td>
</tr><tr>
<td class=tbldata1>сотовый</td><td>
(<input type="text" size="3" name="mobile_code" value="{$mobile_code}">)
<input type="text" size="9" name="mobile_phone" value="{$mobile_phone}"></td>
</tr></table>
</td></tr>
<tr><td class=tblheader1 valign=top>2. Ученая степень</td><td>
<select name=degree value="{$degree}">
<option value="none"{if $degree == 'none'} selected="selected"{/if}>нет</option>
<option value="candidate"{if $degree == 'candidate'} selected="selected"{/if}>канд. наук</option>
<option value="doctor"{if $degree == 'doctor'} selected="selected"{/if}>доктор наук</option>
</select>
</td></tr>
<tr><td class=tblheader1 valign=top>3. Ученое звание</td><td>
<input type=text size=30 name="rank" value="{$rank}"></td></tr>
<tr><td class=tblheader1 valign=top>4. Заслуги</td><td>
<textarea name=zaslugi cols="30">
{$zaslugi}
</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>5. Награды</td><td>
<textarea name=nagrady cols="30">
{$nagrady}
</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>6. Участие в конкурсах (когда и где)</td><td>
<textarea name="konkursy" cols="30">{$konkursy}</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>7. Использование информационных технологий в учебном процессе:</td><td>
<input type="checkbox" value="1" name="it_internet"{if $it_internet} checked="checked"{/if}>&nbsp;Интернет<br/>
<input type="checkbox" value="1" name="it_email"{if $it_email} checked="checked"{/if}>&nbsp;Электронная почта<br/>
<input type="checkbox" value="1" name="it_learning"{if $it_learning} checked="checked"{/if}>&nbsp;Использую в своем предмете<br/>
</td></tr>
<tr><td class=tblheader1 valign=top>8. На курсах хотелось бы получить:</td><td>
<textarea name="extra_info" cols="30">{$extra_info}</textarea>
</td></tr>

</table>

<hr>
<div align=right>
<input type=submit name=save value="Сохранить изменения">
{if $id}<input type=submit onclick="return confirm('Удалить регистрационные данные? (Пользователь сайта не будет удален)');" name=delete value="Удалить"/>{/if}
<input type="button" onclick="window.location='/admin/teacher/mioo_list.php'" value="К списку"/>
</div>
<br/>
<input type=hidden name=id value={$id}>
<input type=hidden name=mioo value="1">
</form>
{include file="footer.tpl"}