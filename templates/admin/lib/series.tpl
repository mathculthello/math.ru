{include file="header.tpl"}
{include file="message.tpl"}
<form name=series method=post action="/admin/lib/series.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} серии</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/lib/series_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
<tr><td class=tblheader1>Путь</td><td><input type=text size=60 name="path" value="{$path}"></td></tr>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="name" value="{$name}"></td></tr>
<tr><td class=tblheader1 valign=top>Описание</td><td><textarea cols=60 rows=20 name="descr">{$descr}</textarea></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/lib/series_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=series value=1>
</form>