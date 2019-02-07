{include file="header.tpl"}
{include file="message.tpl"}
<form name=lecture enctype="multipart/form-data" action="/admin/media/lecture.php" method=post>
<table width=100% height=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} лекции</td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/media/lecture_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
<tr><td width=150 class=tblheader1 valign=top>Название</td><td><input type=text size=80 name="title" value="{$title}"></td></tr>
<tr><td class=tblheader1 valign=top>Раздел</td><td>
<select name=cat>{html_options options=$cat_list selected=$cat}</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Дата</td><td><input type=text size=80 name=date value="{$date}"></td></tr>
<tr><td class=tblheader1 valign=top>Лектор</td><td><input type=text size=80 name=lect value="{$lect}"></td></tr>
<tr><td class=tblheader1 valign=top>Место прочтения</td><td><input type=text size=80 name=place value="{$place}"></td></tr>
<tr><td class=tblheader1 valign=top>Аннотация</td><td><textarea cols=80 rows=20 name=anno>{$anno}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Файл</td>
<td><input type=text name=path value="{$path}"/><input type=button value="Обзор..." onClick="popup=window.open('/admin/media/browse_files.php?form=lecture&field=path','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"></td>
</tr>
<tr><td class=tblheader1 valign=top>Формат</td><td><input type=text size=10 name=codec value="{$codec}"></td></tr>
<tr><td class=tblheader1 valign=top>Ширина (px)</td><td><input type=text size=10 name=width value="{$width}"></td></tr>
<tr><td class=tblheader1 valign=top>Высота (px)</td><td><input type=text size=10 name=height value="{$height}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/media/lecture_list.php?page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value={$id}>
<input type=hidden name=lecture value=1>

{if $id}
<hr/>
<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class="tblheader"><td colspan="3">Кадры</td></tr>
<colgroup width="20"/><colgroup width="300"/><colgroup width="100%"/>
{if $image}
<tr class="tblheader1"><td width="20">X</td><td width="300">Кадр</td><td>Описание</td></tr>
{foreach from=$image item=i}
<tr class="class={cycle values="tbldata1,tbldata2"}" valign="top">
<td><input type="checkbox" name="image_to_delete[{$i.id}]" value="{$i.ext}"/></td>
<td>
<a onclick="popup=window.open('/admin/image.php?src=/media/img/{$id}_image{$i.id}.{$i.ext}&width={$i.width}&height={$i.height}','frame','width={$i.width},height={$i.height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/media/img/{$id}_image{$i.id}.thumb.{$i.ext}" width="{$i.thumb_width}" height="{$i.thumb_height}" border="0"/>
</a>
</td>
<td><textarea rows="5" style="width:80%;" name="image[{$i.id}][descr]">{$i.descr}</textarea></td>
</tr>
{/foreach}
{/if}
<tr class="tblheader"><td colspan="3">Добавить кадр</td></tr>
<tr class="tblheader1"><td width="20"></td><td width="300">Файл</td><td>Описание</td></tr>
<tr valign="top"><td></td>
<td><input type="file" name="new_image_file"/></td>
<td><textarea rows="5" name="new_image_descr" style="width:80%"></textarea></td>
</tr>
</table>
{/if}

</form>
{include file="footer.tpl"}