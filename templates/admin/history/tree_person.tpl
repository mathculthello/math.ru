{include file="header.tpl"}
{include file="message.tpl"}
<form name="person" method="post" enctype="multipart/form-data" action="/admin/history/tree_person.php">
<table width=100%>
<tr class=tblheader><td align=right colspan="2"><input type=submit name=delete value="Удалить"> <input type=submit name=publish value="Опубликовать"> <input type=submit name=save value="Сохранить изменения"></td></tr>
<tr><td class=tblheader1>Учитель:</td><td><a href="/admin/h_tree_person.php?id={$pid}">{$pfullname}</a></td></tr>
<tr><td class=tblheader1>Фамилия:</td><td> <input type=text size=15 name="lname" value="{$lname}"></td></tr>
<tr><td class=tblheader1>Имя:</td><td> <input type=text size=15 name="fname" value="{$fname}"></td></tr>
<tr><td class=tblheader1>Отчество:</td><td> <input type=text size=15 name="sname" value="{$sname}"></td></tr>
{if !$tree_id}
<tr><td class=tblheader1>Путь</td><td> <input type=text size=15 name="path" value="{$path}"></td></tr>
{/if}
{if $portrait}
<tr>
<td class=tblheader1>Портрет</td>
<td>
<input type="hidden" name="portrait" value="{$portrait}"/>
<input type="hidden" name="portrait_width" value="{$portrait_width}"/>
<input type="hidden" name="portrait_height" value="{$portrait_height}"/>
<input type="hidden" name="thumb_width" value="{$thumb_width}"/>
<input type="hidden" name="thumb_height" value="{$thumb_height}"/>
<a onclick="popup=window.open('/admin/history/portrait.php?src=/history/tree/new_portrait/{$id}.{$portrait}&width={$portrait_width}&height={$portrait_height}','portrait','width={$portrait_width},height={$portrait_height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/tree/new_portrait/{$id}.thumb.{$portrait}" width="{$thumb_width}" height="{$thumb_height}" border="0"/>
</a>
</td></tr>
{/if}
<tr>
<td class=tblheader1>Загрузить{if $portrait} новый{/if} портрет</td>
<td><input type="file" name="portrait_file"></td>
</tr>
{if $portrait}
<tr>
<td class=tblheader1>Удалить портрет</td>
<td><input type="checkbox" name="delete_portrait"></td>
</tr>
{/if}
<tr><td class=tblheader1>Дата рождения (гггг-мм-дд)</td><td> <input type=text size=15 name="birth_date" value="{$birth_date}"></td></tr>
<tr><td class=tblheader1>Дата смерти (гггг-мм-дд)</td><td> <input type=text size=15 name="death_date" value="{$death_date}"></td></tr>
<tr><td class=tblheader1 valign=top>Биографическая справка</td><td><textarea cols=60 rows=20 name=shortbio>{$shortbio}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>Область научных интересов</td><td><textarea cols=60 rows=10 name=area>{$area}</textarea></td></tr>
<tr><td colspan=2 class=tblheader>Информация о добавляющем</td></tr>
<tr><td class=tblheader1>ФИО</td><td><input type=text name=name value="{$name}"></td></tr>
<tr><td class=tblheader1>Профессия</td><td><input type=text name=occupation value="{$occupation}"></td></tr>
<tr><td class=tblheader1>Место работы</td><td><input type=text name=job value="{$job}"></td></tr>
<tr><td class=tblheader1>Контакты</td><td><input type=text name=contacts value="{$contacts}"></td></tr>
<tr class=tblheader><td align=right colspan="2"><input type=submit name=delete value="Удалить"> <input type=submit name=publish value="Опубликовать"> <input type=submit name=save value="Сохранить изменения"></td></tr>
<input type=hidden name=pid value="{$pid}">
<input type=hidden name=tree_id value="{$tree_id}">
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
</table>
</form>
{include file="footer.tpl"}
