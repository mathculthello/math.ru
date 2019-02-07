{include file="header.tpl"}
{literal}
<script type="text/javascript" language="javascript">
<!--
function setSelectOptions(the_form, the_select, do_check)
{
    var selectObject = document.forms[the_form].elements[the_select];
    var selectCount  = selectObject.length;

    for (var i = 0; i < selectCount; i++) {
        selectObject.options[i].selected = do_check;
    } // end for

    return true;
}

var focusedElement;
//-->
</script>
{/literal}
<form name=book enctype="multipart/form-data" action="/admin/lib/book.php" method=post>

<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} книги</td></tr>
</table>
<table width=100%>
<tr><td align="right">
<input type=submit name=save value="Сохранить">
{*
 <input type=button value="TeX->png" onClick="popup=window.open('/admin/lib/book_tex2png.php?id={$id}','tex2png','width=800,height=600,left=' + ((screen.width-800)/2) + ',top=' + ((screen.height-600)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;">
{if $id && $_user_status == 'admin'}<input type=submit name=delete value="Удалить" onclick="return confirm('Удалить книгу?');"/>{/if}
*}
<input type="button" onclick="window.location='/admin/lib/book_list.php'" value="К списку"/>
</td></tr>
</table>
<hr>
{include file="message.tpl"}

<table width=100% align='center' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td style='padding-right: 2px;'>
<input class='tabOn' id='tab0' type='button' value='Основная информация' onclick='showTabPage(0,4)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab1' type='button' value='Файлы' onclick='showTabPage(1,4)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab2' type='button' value='Тематический каталог' onclick='showTabPage(2,4)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab3' type='button' value='Отрывки' onclick='showTabPage(3,4)'>
</td>
<td width='100%'>&nbsp;</td>
</tr>
</table>

<table class='tabPage' valign='top' width='100%'>
<tr><td>

<span style='background-color:#F2F2F2;display:block;' id='page0'>

<table width=100%>
<tr><td width=150 class=tblheader1 valign=top>Название</td><td><input type=text size=80 name=title value="{$title}"></td></tr>
<tr><td width=150 class=tblheader1 valign=top>Подзаголовок</td><td><input onFocus="focusedElement=this;" type=text size=80 name=subtitle value="{$subtitle}"></td></tr>
<tr><td class=tblheader1 valign=top>Авторы</td>
<td>
{if $person_list}
<table cellspacing=0 cellpadding=0>
{foreach from=$person_list item=a}
<tr><td>
<input type=checkbox name="person_to_delete[]" value="{$a.id}">
</td><td>
<input type=hidden name="person[]" value="{$a.id}">
<select name="spelling[{$a.id}]">
<option label="$a.fullname" value=0>{$a.fullname}</option>
{html_options options=$spelling_options[$a.id] selected=$spelling[$a.id]}
</select>
</td></tr>
{/foreach}
</table><br/>
<input type=submit style="width:200px;" name="person_delete" value="Удалить отмеченных">
{/if}
<input type=hidden name="person_to_insert" value="">
<input type=button style="width:200px;" value="Добавить автора(-ов)" onClick="popup=window.open('/admin/history/person_picker.php?form_name=book&element_name=person_to_insert&reload=1&ismultiple=1','picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;">

</td></tr>
<tr><td class=tblheader1 valign=top>Раздел</td><td>
<select name=type>
{html_options options=$types selected=$type}
</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Серия</td><td>
<select name=series>
<option value=''> - </option>
{html_options options=$series_list selected=$series}
</select>
</td></tr>
<tr><td class=tblheader1>Номер</td><td><input type=text size=10 name=num value="{$num}"></td></tr>
<tr><td class=tblheader1 valign=top>Год</td><td><input type=text size=10 name=year value="{$year}"></td></tr>
<tr><td class=tblheader1 valign=top>Число страниц</td><td><input type=text size=10 name=pages value="{$pages}"></td></tr>
<tr><td class=tblheader1 valign=top>Тираж</td><td><input type=text size=10 name=copies value="{$copies}"></td></tr>
<tr><td class=tblheader1 valign=top>ISBN</td><td><input type=text size=20 name=ISBN value="{$ISBN}"></td></tr>
<tr><td class=tblheader1 valign=top>Издательство</td><td><input type=test size=50 name=publ value="{$publ}"></td></tr>
<tr><td class=tblheader1 valign=top>Издание</td><td><input type=test size=50 name=edition value="{$edition}"></td></tr>
<tr><td class=tblheader1 valign=top>Аннотация</td><td><textarea onFocus="focusedElement=this;" cols=80 rows=20 name=anno>{$anno}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Содержание</td><td><textarea onFocus="focusedElement=this;" cols=80 rows=20 name=contents>{$contents}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Список литературы</td><td><textarea onFocus="focusedElement=this;" cols=80 rows=10 name=biblio>{$biblio}</textarea></td></tr>
</table>

<input type="button" value="Ссылка на персону" onclick="popup=window.open('/admin/history/person_picker.php?form_name=book&text_element_name='+focusedElement.name+'&insert_link=/history/people/','person_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
</span>
<span style='background-color:#F2F2F2;display:none;' id='page1'>

<table cellpadding=3>
<tr class=tblheader1 valign=top><td></td><td>файл</td><td>размер</td><td>удалить</td><td>путь</td><td>upload</td><td>Смещение</td></tr>
<tr>
<td class=tblheader1 valign=top>djvu</td>
<td>{if $djvu_name}<a href="/lib/files/{$djvu_name}"><input type=hidden name=djvu_path value="{$djvu_name}">{$djvu_name}</a>{else}-{/if}</td>
<td>{$djvu}</td><td><input type=checkbox name=djvu_remove></td>
<td>{if !$djvu}<input type=text name=djvu_path value="{$djvu_path}"/><input type=button value="Обзор..." onClick="popup=window.open('/admin/lib/browse_files.php?form=book&field=djvu_path&filter=djvu&path=/djvu/','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"> {/if}</td>
<td>{if !$djvu}<input type=file name="djvu_file">{/if}</td>
<td><input type="text" name="djvu_shift" value="{$djvu_shift|default:1}"/></td>
</tr>
<tr>
<td class=tblheader1 valign=top>pdf</td>
<td>{if $pdf_name}<a href="/lib/files/{$pdf_name}"><input type=hidden name=pdf_path value="{$pdf_name}">{$pdf_name}</a>{else}-{/if}</td>
<td>{$pdf}</td><td><input type=checkbox name=pdf_remove></td>
<td>{if !$pdf}<input type=text name=pdf_path value="{$pdf_path}"/><input type=button value="Обзор..." onClick="popup=window.open('/admin/lib/browse_files.php?form=book&field=pdf_path&filter=pdf&path=/pdf/','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"/>{/if}</td>
<td>{if !$pdf}<input type=file name="pdf_file">{/if}</td></tr>
<td></td>
<tr>
<td class=tblheader1 valign=top>ps</td>
<td>{if $ps_name}<a href="/lib/files/{$ps_name}"><input type=hidden name=ps_path value="{$ps_name}">{$ps_name}</a>{else}-{/if}</td>
<td>{$ps}</td><td><input type=checkbox name=ps_remove></td>
<td>{if !$ps}<input type=text name=ps_path value="{$ps_path}"><input type=button value="Обзор..." onClick="popup=window.open('/admin/lib/browse_files.php?form=book&field=ps_path&filter=ps','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"/>{/if}</td>
<td>{if !$ps}<input type=file name="ps_file">{/if}</td>
<td></td>
</tr>
<tr>
<td class=tblheader1 valign=top>html</td>
<td>{if $html_name}<a href="/lib/files/{$html_name}"><input type=hidden name=html_path value="{$html_name}">{$html_name}</a>{else}-{/if}</td>
<td>{$html}</td>
<td><input type=checkbox name=html_remove></td>
<td>{if !$html}<input type=text name=html_path value="{$html_path}"/><input type=button value="Обзор..." onClick="popup=window.open('/admin/lib/browse_files.php?form=book&field=html_path&filter=html','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"/>{/if}</td>
<td>{if !$html}<input type=file name="html_file"/>{/if}</td>
<td></td>
</tr>
<tr>
<td class=tblheader1 valign=top>tex</td>
<td>{if $tex_name}<a href="/lib/files/{$tex_name}"><input type=hidden name=tex_path value="{$tex_name}">{$tex_name}</a>{else}-{/if}</td>
<td>{$tex}</td><td><input type=checkbox name=tex_remove></td>
<td>{if !$tex}<input type=text name=tex_path value="{$tex_path}"><input type=button value="Обзор..." onClick="popup=window.open('/admin/lib/browse_files.php?form=book&field=tex_path&filter=tex','browse_files','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;"/>{/if}</td>
<td>{if !$tex}<input type=file name="tex_file">{/if}</td>
<td></td>
</tr>
</table>

</span>
<span style='background-color:#F2F2F2;display:none;' id='page2'>

<select name="catalog[]" multiple>
{foreach from=$catalog_list item=s key=i}
<option value="{$i}"{if $s.checked} selected{/if}>{""|indent:$s.level-1:"&nbsp;&nbsp;&nbsp;&nbsp;"}{$s.name}</option>
{/foreach}</select>
<br>
<a href="" onclick="setSelectOptions('book', 'catalog[]', false); return false;">Снять отметку со всех</a>
<br/>
<select name="rubr[]" multiple>
{foreach from=$rubr_list item=s key=i}
<option value="{$i}"{if $s.checked} selected{/if}>{$s.name}</option>
{/foreach}</select>
<br/>
<a href="" onclick="setSelectOptions('book', 'rubr[]', false); return false;">Снять отметку со всех</a>

</span>

<span style='background-color:#F2F2F2;display:none;' id='page3'>
{include file="lib/ad_list.tpl"}
</span>

</td></tr></table>

<hr>
<table width=100%>
<tr><td align="right">
<input type=submit name=save value="Сохранить">
{*
{if $id} <input type=button value="TeX->png" onClick="popup=window.open('/admin/lib/book_tex2png.php?id={$id}','tex2png','width=800,height=600,left=' + ((screen.width-800)/2) + ',top=' + ((screen.height-600)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;"> <input type=submit name=delete value="Удалить" onclick="return confirm('Удалить книгу?');"/>{/if}
*}
{if $id && $_user_status == 'admin'}<input type=submit name=delete value="Удалить" onclick="return confirm('Удалить книгу?');"/>{/if}
<input type="button" onclick="window.location='/admin/lib/book_list.php'" value="К списку"/>
</td></tr>
</table>
<input type=hidden name=id value={$id}>
<input type=hidden name=book value=1>

</form>

{include file="footer.tpl"}