{include file="header.tpl"}
{include file="message.tpl"}
<form name=story method=post action="/admin/history/story.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} сюжета</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/history/story_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
<tr><td class=tblheader1>Заголовок</td><td><input type=text size=80 name="title" value="{$title}"></td></tr>
<tr><td class=tblheader1 valign="top">Текст</td><td><textarea style="width:100%" cols=60 rows=20 name="text">{$text}</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/history/story_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=story value=1>
{if $id}
<hr/>
{include file="generic_list.tpl" _picker_href="/admin/history/person_picker.php?" _related="person" _show_delete="1" _delete_name="person_delete" _no_form="1" _form_name="story" _show_checkboxes="1" _checkboxes_name="person_to_delete" _checkboxes_key="id" _show_insert="1" _header="Связанные персоны" _rows=$person_list _columns=$person_columns _href="/admin/history/person_list.php?" _item_href="/admin/history/person.php?"}
{/if}
</form>
{include file="footer.tpl"}