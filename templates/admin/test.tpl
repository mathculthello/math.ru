{include file="header.tpl"}
{include file="message.tpl"}

<form name=test method=post action="/admin/test.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} фигни</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/test_list.php'" value="К списку"/></td></tr>
<tr><td class=tblheader1 valign=top>Заголовок</td><td><input type="text" name="txt" value="{$txt}"/></td></tr>
<tr><td class=tblheader1 valign="top">Текст</td><td><textarea cols=60 rows=10 name="text">{$text}</textarea></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/test_list.php'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=test value=1>
</form>
