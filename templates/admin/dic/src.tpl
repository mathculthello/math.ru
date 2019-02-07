{include file="header.tpl"}
{include file="message.tpl"}

<form name=story method=post action="/admin/dic/src.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} источника</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/dic/src_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
<tr><td class=tblheader1 valign=top>Код</td><td>
<input type=text size=32 name="code" value="{$code}">
</td></tr>
<tr><td class=tblheader1>Вид источника</td><td>
<select name="type">
{html_options options=$type_options selected=$type}
</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Заголовок</td><td>
<input type=text size=80 name="title" value="{$title}">
</td></tr>
<tr><td class=tblheader1 valign=top>Авторы</td><td>
<input type=text size=80 name="author" value="{$author}">
</td></tr>
<tr><td class=tblheader1 valign=top>Год</td><td>
<input type=text size=5 name="year" value="{$year}">
</td></tr>
<tr><td class=tblheader1>Класс</td><td>
с <select name="grade_from">{html_options options=$grade_options selected=$grade_from}</select> по <select name="grade_to">{html_options options=$grade_options selected=$grade_to}</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Издательство</td><td>
<input type=text size=80 name="publ" value="{$publ}">
</td></tr>

<tr><td class=tblheader1 valign="top">Комментарий</td><td>
<textarea cols=60 rows=10 name="comment">{$comment}</textarea>
</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/dic/src_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=src value=1>
</form>
