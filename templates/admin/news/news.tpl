{include file="header.tpl"}
{include file="message.tpl"}

<form name=story method=post action="/admin/news/news.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} новости</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/news/index.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
<tr><td class=tblheader1>Дата</td><td><input type=text size=80 name="date" value="{$date}"></td></tr>
<tr><td class=tblheader1 valign=top>Заголовок</td><td><textarea cols=60 rows=10 name="title">{$title}</textarea></td></tr>
<tr><td class=tblheader1 valign="top">Текст</td><td><textarea cols=60 rows=10 name="text">{$text}</textarea></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/news/index.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=news value=1>
</form>
