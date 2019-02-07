{include file="header.tpl"}
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} статьи</td></tr>
</table>
{include file="message.tpl"}
<br/>

<form name=article enctype="multipart/form-data" action="/admin/teacher/article.php" method=post>

<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Название</td><td><input type=text size=80 name=title value="{$title}"></td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>Текст</td><td><textarea name=txt cols=80 rows=20>{$txt}</textarea></td></tr>
{if $path}
<tr><td class=tblheader1 valign=top>Архив</td><td><a href="/teacher/article/{$path}"><input type="hidden" name="size" value="{$size}"><input type="hidden" name="path" value="{$path}">{$path}</a></td></tr>
<tr><td class=tblheader1 valign=top>Удалить архив</td><td><input type="checkbox" name="delete_file"/></td></tr>
{/if}
<tr>
<td class=tblheader1 valign=top>Загрузить{if $path} новый{/if} архив</td>
<td><input type=file name="upload_file"/></td>
</tr>
<tr><td class=tblheader1 valign=top>Раздел форума для обсуждения</td><td><select name="forum"><option value=0 label=" -- "> -- </option>{html_options options=$forum_options selected=$forum}</select></td></tr>
</table>

<hr>
<div align=right>
<input type=submit name=save value="Сохранить">
{if $id}<input type=submit onclick="return confirm('Удалить статью?');" name=delete value="Удалить"/>{/if}
<input type="button" onclick="window.location='/admin/teacher/article_list.php'" value="К списку"/>
</div>

<input type=hidden name=id value={$id}>
<input type=hidden name=article value=1>
</form>
{include file="footer.tpl"}