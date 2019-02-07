{include file="header.tpl"}
{include file="message.tpl"}
<form name=author method=post action="/admin/lib/rubr.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} рубрики</td></tr>
<tr><td class=tblheader1>Путь</td><td><input type=text size=60 name="path" value="{$path}"></td></tr>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="name" value="{$name}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/lib/rubr_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=rubr value=1>
</form>