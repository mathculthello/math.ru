{include file="header.tpl"}

<form method=post action=/admin/teacher/mioo_list.php name=register>
<table cellpadding=2 width="100%">
<tr class=tblheader><td colspan="3">Поиск</td></tr>
<tr>
<td class="tblheader1">Курс:&nbsp;
<select name="course">
<option value="0" title="Все">Все</option>{html_options options=$course_options selected=$course}</select>
<a href="#" title="Выбрать курс из списка" onclick="popup=window.open('/teacher/course_picker.php','_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
Выбрать курс</a>
</td>
<td class="tblheader1">Год:&nbsp;
<select name="sch_year">
<option value="0" title="Все">Все</option>
{html_options options=$year_options selected=$sch_year}</select>
</td><td class="tblheader1"><input type=submit value="Найти"/> <a href="#" onclick="toggleBox(0, 1);">Сохранить &raquo;</a></td>
</tr>
</table>

<span style="background-color:#F2F2F2;display:none;" id="box0">
<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Формат</td><td>
<select name="format"><option label="csv" value="csv">csv</option><option label="xls" value="xls">xls</option></select>
</td></tr>
<tr><td class=tblheader1 valign=top>Поля</td><td>
<select name="fields" multiple="multiple">
{html_options options=$fields_options}
</select>
</td></tr>
<tr><td colspan="2" align="right"><input type="button" onclick="document.location='/admin/teacher/mioo_export.php?sch_year=' + document.register.sch_year[document.register.sch_year.selectedIndex].value + '&course=' + document.register.course[document.register.course.selectedIndex].value + '&format=' + document.register.format[document.register.format.selectedIndex].value" value="Сохранить"></td></tr>
</table>
</span>

<input type=hidden name=search value=1>
</form>

<hr size=1 noshade=1 />
{include file="generic_list.tpl" _form_name="mioo_list" _show_insert="0" _header="Регистрация на курсы МИОО" _rows=$user _href="/admin/teacher/mioo_list.php?" _item_href="/admin/teacher/mioo_user.php?" _show_pager="1"}
{include file="footer.tpl"}