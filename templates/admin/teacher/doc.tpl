{include file="header.tpl"}
{include file="message.tpl"}
<form name=doc method=post enctype="multipart/form-data" action="/admin/teacher/doc.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} документа</td></tr>
<tr><td class=tblheader1>Название</td><td><input type=text size=60 name="title" value="{$title}"></td></tr>
<tr><td class=tblheader1 valign=top>Раздел</td><td>
<select name=cat>{html_options options=$cat_list selected=$cat}</select>
</td></tr>
{if $path}
<tr><td class=tblheader1 valign=top>Архив</td><td><a href="/teacher/doc/{$path}"><input type="hidden" name="size" value="{$size}"><input type="hidden" name="path" value="{$path}">{$path}</a></td></tr>
<tr><td class=tblheader1 valign=top>Удалить архив</td><td><input type="checkbox" name="delete_file"/></td></tr>
{/if}
<tr>
<td class=tblheader1 valign=top>Загрузить{if $path} новый{/if} архив</td>
<td><input type=file name="upload_file"/></td>
</tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/teacher/doc_list.php'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=doc value=1>

{if $id}
<hr/>
<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class="tblheader"><td colspan="3">HTML-файлы</td></tr>
<colgroup width="20"/><colgroup/><colgroup/>
{if $file}
<tr class="tblheader1"><td width="20">X</td><td>Файл</td><td>Заголовок</td></tr>
{foreach from=$file item=f}
<tr class="class={cycle values="tbldata1,tbldata2"}" valign="top">
<td><input type="checkbox" name="file_to_delete[{$f.id}]" value="{$f.path}"/></td>
<td>
<a href="/teacher/html/{$id}_{$f.id}.htm">{$id}_{$f.id}.htm</a>
</td>
<td><input type="text" name="file[{$f.id}][title]" style="width:100%" value="{$f.title}"></td>
</tr>
{/foreach}
{/if}
<tr class="tblheader"><td colspan="3">Новый файл</td></tr>
<tr class="tblheader1"><td width="20"></td><td width="300">Файл</td><td>Заголовок</td></tr>
<tr valign="top"><td></td>
<td><input type="file" name="new_file_file"/></td>
<td><input type=text name="new_file_title" style="width:100%"/></td>
</tr>
</table>

<hr/>
<table width=100%>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/teacher/doc_list.php'" value="К списку"/></td></tr>
</table>
{/if}


</form>
{include file="footer.tpl"}
