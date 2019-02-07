<table valign="top"><tr><td valign="top">
<form method=post action=/admin/lib/book_list.php name=lib_book_search>
<table cellpadding=2 valign="top">
<tr class=tblheader><td>Поиск</td></tr>
<tr>
<td class="tblheader1" align=right>
Ключевые слова:&nbsp;<input type=text name=search_keyword value="{$search_keyword}"/> 
<NOBR>Авторы:&nbsp;<input type=text name=search_author value="{$search_author}"/></NOBR>
</td></tr>
<tr>
<td class="tblheader1" align="left">
Серия:&nbsp;<select name=search_series style="width:300px"><option value=0 label=" -- "> -- </option>{html_options options=$series_options selected=$search_series}</select> 
<NOBR>Раздел ТК: <select name=search_subj style="width:100px"><option value=0 label=" -- "> -- </option>{html_options options=$subj_options selected=$search_subj}</select></nobr>
</td></tr>
<td class="tblheader1" align=right>&nbsp;<input type=submit value="Найти"/></td></tr>
</table>
<input type=hidden name=search value=1>
</form>
</td><td valign="top">
<table cellpadding=2 valign="top">
<tr class=tblheader><td>Алфавитный каталог</td></tr>
<tr class="tblheader1"><td>
{include file="generic_alpha.tpl" _href="/admin/lib/book_list.php?letter="}
</td></tr></table>
</td></tr></table>
