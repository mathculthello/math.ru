{include file="teacher/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl" _path="/teacher/"}
<br/>
{include file="teacher/courses_menu.tpl" _path="/teacher/courses.php"}
	</td>
<td id=content valign=top align=center><div>
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

{if $_user_reg_mioo}
<h1>Регистрационные данные для курсов МИОО</h1>
<table align="right"><tr><td><a href="/teacher/courses_print.php">Версия для печати.</a></td></tr></table>
{else}
<h1>Регистрация на курсы МИОО</h1>
{/if}
<br/>
{include file="admin/message.tpl"}
<form method=post action=/teacher/courses.php name=register>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>

{if $_user_loggedin}

{else}
<tr><td><h2>Регистрация на сайте.</h2>
Регистрация пользователя даст возможность работать на 
<A href="http://www.math.ru">сервере math.ru</A> (пользоваться библиотекой,
материалами по истории науки, медиатекой) участвовать в форумах и т.д.
</td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=center colspan=2 class=tbldata1>Первые четыре поля заполняются в этой форме ТОЛЬКО в том случае,<BR>
когда у Вас нет своего логина на сервере MATH.RU,<BR> иначе надо  
<a href="/auth/login.php">войти под своим логином</a>,<BR> а потом пройти дальнейшую регистрацию.</td></tr>
<tr><td align=right class=tbldata1>Логин:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><input type=text size=30 name="newlogin" value="{$newlogin}"></td></tr>
<tr><td align=right class=tbldata1>Email:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small>Email будет использован для восстановления забытого пароля.</div></td><td>
<input type=text size=30 name=email value="{$email}"></td></tr>
<tr><td align=right class=tbldata1>Пароль:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=password size=30 name=password></td></tr>
<tr><td align=right class=tbldata1>Подтверждение пароля:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small align=right>Введите еще раз новый пароль.</div></td><td>
<input type=password size=30 name=password2></td></tr>
</table></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
{/if}
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td><h2>Общие данные</h2></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Учебный год</td><td class=tbldata2>
<select name="sch_year">{html_options options=$year_options selected=$sch_year}</select>
</td></tr>
<tr><td align=right class=tbldata1>Шифр курса<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a>
<br/><br/>
<div class="small">
Выберите в выпадающем списке шифр курса. Если вы не помните шифр, нажмите "Выбрать курс" и во всплывшем окне нажмите на название курса.
</div>
</td><td valign="top">
<select name="course"><option value="0"></option>{html_options options=$course_options selected=$course}</select>
<a href="#" title="Выбрать курс из списка" onclick="popup=window.open('/teacher/course_picker.php','_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
Выбрать курс</a>
</td></tr>
</table></td></tr>

<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1 valign="top">1. Фамилия, имя и<BR>отчество<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td>
<td class=tbldata2>

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
<tr><td align=right class=tbldata1 valign="top">2. Документ, удостоверяющий личность<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2>
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
<tr><td align=right class=tbldata1>3. Дата рождения<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2>
<select name="birthdate_day">{html_options options=$birthdate_day_options selected=$birthdate_day}</select>
<select name="birthdate_month">{html_options options=$birthdate_month_options selected=$birthdate_month}</select>
<input type=text size=5 name="birthdate_year" value="{$birthdate_year}">
</td></tr>
<tr><td align=right class=tbldata1>4. Пол<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><select name="sex"><option value="m"{if $sex == 'm'} selected="selected"{/if}>М</option><option value="w"{if $sex == 'w'} selected="selected"{/if}>Ж</option></select></td></tr>
<tr><td align=right class=tbldata1>5. Образование<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td>
<td class=tbldata2><select name="edu">
<option value="high"{if $edu == 'high'} selected="selected"{/if}>высшее</option>
<option value="high1"{if $edu == 'high1'} selected="selected"{/if}>неполное высшее</option>
<option value="col"{if $edu == 'col'} selected="selected"{/if}>среднее специальное</option>
</select>
</td></tr>
<tr><td align=right class=tbldata1>6. Когда и какое учебное заведение окончил(а)<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td>
<td class=tbldata2><input type=text size=60 name="edu_school" value="{$edu_school}"></td></tr>
<tr><td align=right class=tbldata1>7. Специальность по диплому<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><input type=text size=30 name="edu_spec" value="{$edu_spec}"></td></tr>
<tr><td align=right class=tbldata1>8. Квалификация по диплому<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><input type=text size=30 name="edu_qual" value="{$edu_qual}"></td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td><h2>Данные о месте работы</h2></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>

<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1 valign="top">1. Место работы (обр. учреждение) <a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2>
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
<td class="tbldata1">полное название:&nbsp;</td><td><input type=text size=30 name="school_name" value="{$school_name|escape}"></td>
</tr></table>

</td></tr>
<tr><td align=right class=tbldata1 valign="top">2. Адрес образовательного учреждения и округ<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>

<table cellpadding="5"><tr>
<td class="tbldata1">индекс:&nbsp;</td>
<td><input type="text" size="7" name="school_addr_zip" value="{$school_addr_zip|escape}"></td>
<td class="tbldata1">город:&nbsp;</td>
<td><input type="text" size="10" name="school_addr_city" value="{$school_addr_city|escape}"></td>
</tr><tr>
<td class="tbldata1">адрес:&nbsp;</td>
<td><input type="text" size="10" name="school_addr_txt" value="{$school_addr_txt|escape}"></td>
<td class="tbldata1">округ:&nbsp;</td>
<td>
<select name="school_addr_dist">
{html_options options=$dist_options selected=$school_addr_dist}
</select>
</td></tr></table>

</td></tr>

<tr><td align=right class=tbldata1>3. Должность и дата назначения<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=60 name=school_pos value="{$school_pos|escape}"></td></tr>
<tr><td align=right class=tbldata1>4. Стаж педагогический<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=5 name=school_exp_teacher value="{$school_exp_teacher|escape}">&nbsp;полных лет</td></tr>
<tr><td align=right class=tbldata1>5. Стаж руководящей работы</td><td>
<input type=text size=5 name=school_exp_director value="{$school_exp_director|escape}">&nbsp;полных лет</td></tr>
<tr><td align=right class=tbldata1>6. Квалификационная категория<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<table cellpadding="5"><tr>
<td class=tbldata1>разряд</td><td><input type=text size=4 name=school_cat_num value="{$school_cat_num|escape}"></td>
<td class="tbldata1">год и место присвоения</td><td><input type=text size=30 name=school_cat value="{$school_cat|escape}"></td>
</tr></table>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">7. Повышение квалификации.</td><td>
<table>
<tr><td colspan="2" class="tbldata1">Последнее повышение квалификации</td></tr>
<tr><td class="tbldata1">Тема курса, количество часов</td><td><input type="text" size="30" name="school_lastcourse_subj" value="{$school_lastcourse_subj|escape}"></td></tr>
<tr><td class="tbldata1">Даты прохождения курса (с…по...)</td><td><input type="text" size="30" name="school_lastcourse_period" value="{$school_lastcourse_period|escape}"></td></tr>
<tr><td class="tbldata1">Место прохождения</td><td><input type="text" size="30" name="school_lastcourse_place" value="{$school_lastcourse_place|escape}"></td></tr>
<tr><td class="tbldata1">Документ-основание<br>(удостоверение, свидетельство, зачетная книжка, № документа)</td><td><input type="text" size="30" name="school_lastcourse_doc" value="{$school_lastcourse_doc|escape}"></td></tr>
</table>

</td></tr>

<tr><td align=right class=tbldata1 valign="top">8. Если Вы закончили какие-либо другие дополнительные курсы повышения квалификации, укажите их</td><td>
<textarea name="school_courses" cols="30">
{$school_courses|escape}
</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">9. Тема методической работы</td><td>
<textarea name="school_met" cols="30">
{$school_met|escape}
</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">10. Тема экспериментальной работы (если таковая ведется)</td><td>
<textarea name="school_exp" cols="30">
{$school_exp|escape}
</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">11. Участие в методической работе (наставник, разработчик, эксперт, иное, укажите что именно)</td><td>
<textarea name="school_met_role" cols="30">
{$school_met_role|escape}
</textarea>
</td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td><h2>Дополнительная информация<h2></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>

<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1 valign="top">1. Телефон</td><td>
<table cellpadding="5"><tr>
<td class=tbldata1>домашний</td><td>
(<input type="text" size="3" name="contact_code" value="{$contact_code|escape}">)
<input type="text" size="9" name="contact_phone" value="{$contact_phone|escape}"></td>
</tr><tr>
<td class=tbldata1>рабочий</td><td>
(<input type="text" size="3" name="work_code" value="{$work_code|escape}">)
<input type="text" size="9" name="work_phone" value="{$work_phone|escape}"></td>
</tr><tr>
<td class=tbldata1>сотовый</td><td>
(<input type="text" size="3" name="mobile_code" value="{$mobile_code|escape}">)
<input type="text" size="9" name="mobile_phone" value="{$mobile_phone|escape}"></td>
</tr></table>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">2. Ученая степень</td><td>
<select name=degree value="{$degree}">
<option value="none"{if $degree == 'none'} selected="selected"{/if}>нет</option>
<option value="candidate"{if $degree == 'candidate'} selected="selected"{/if}>канд. наук</option>
<option value="doctor"{if $degree == 'doctor'} selected="selected"{/if}>доктор наук</option>
</select>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">3. Ученое звание</td><td>
<input type=text size=30 name="rank" value="{$rank}"></td></tr>
<tr><td align=right class=tbldata1 valign="top">4. Заслуги</td><td>
<textarea name=zaslugi cols="30">
{$zaslugi|escape}
</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">5. Награды</td><td>
<textarea name=nagrady cols="30">
{$nagrady|escape}
</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">6. Участие в конкурсах (когда и где)</td><td>
<textarea name="konkursy" cols="30">{$konkursy|escape}</textarea>
</td></tr>
<tr><td align=right class=tbldata1 valign="top">7. Использование информационных технологий в учебном процессе:</td><td>
<input type="checkbox" value="1" name="it_internet"{if $it_internet} checked="checked"{/if}>&nbsp;Интернет<br/>
<input type="checkbox" value="1" name="it_email"{if $it_email} checked="checked"{/if}>&nbsp;Электронная почта<br/>
<input type="checkbox" value="1" name="it_learning"{if $it_learning} checked="checked"{/if}>&nbsp;Использую в своем предмете<br/>
</td></tr>

<tr><td align=right class=tbldata1 valign="top">8. На курсах хотелось бы получить:</td><td>
<textarea name="extra_info" cols="30">{$extra_info|escape}</textarea>
</td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>

<tr><td align=right><input type=submit name=register value="Отправить" class="button"></td></tr>
</table>
</form>
<br/>
</div></td>

	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>

</tr>
{include file="footer.tpl"}