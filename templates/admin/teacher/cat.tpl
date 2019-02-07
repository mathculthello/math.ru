{include file="header.tpl"}
{include file="message.tpl"}
<form name=cat method=post action="/admin/teacher/cat.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} раздела</td></tr>
<tr><td class=tblheader1>Путь</td><td><input type=text size=60 name="path" value="{$path}"></td></tr>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="title" value="{$title}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/teacher/cat_list.php'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=cat value=1>
</form>
{include file="footer.tpl"}
