<table><tr><td valign="top">
<form method=post action=/admin/history/person_list.php name=h_person_search>
<table cellpadding=2>
<tr class=tblheader><td>Поиск</td></tr>
<tr>
<td class="tblheader1" align=right>Фамилия:&nbsp;<input type=text name=lname value="{$lname}"/>
&nbsp;<input type=submit value="Найти"/></td></tr>
</table>
<input type=hidden name=search value=1>
</form>
</td><td>
<table cellpadding=2>
<tr class=tblheader><td>Алфавитный каталог</td></tr>
<tr class="tblheader1"><td>
{include file="generic_alpha.tpl" _href="/admin/history/person_list.php?letter="}
</td></tr></table>
</td></tr></table>
