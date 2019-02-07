{include file="header.tpl"}

<form name="person" method="post" enctype="multipart/form-data" action="/admin/history/person.php">

<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} персоны</td></tr>
<tr class=tblheader><td colspan="2" align=right>
{if $id && !$image && !$books && !$story && !$tree_path}
<input type=button name="delete" onclick="confirmGo('Удалить персону?', '/admin/history/person.php?delete=1&id={$id}')" value="Удалить">
{/if}
<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/history/person_list.php'" value="К списку"/></td></tr>
</table>

{include file="message.tpl"}
<br/>

{if $id}
<table width=100% align='center' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td style='padding-right: 2px;'>
<input class='tabOn' id='tab0' type='button' value='Основная информация' onclick='showTabPage(0,5)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab1' type='button' value='Древо Лузина' onclick='showTabPage(1,5)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab2' type='button' value='Книги' onclick='showTabPage(2,5)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab3' type='button' value='Сюжеты' onclick='showTabPage(3,5)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab4' type='button' value='Фотографии' onclick='showTabPage(4,5)'>
</td>
<td width='100%'>&nbsp;</td>
</tr>
</table>
{else}
<table width=100% align='center' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td style='padding-right: 2px;'>
<input class='tabOn' id='tab0' type='button' value='Основная информация' onclick='showTabPage(0,2)'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab1' type='button' value='Древо Лузина' onclick='showTabPage(1,2)'>
</td>
<td width='100%'>&nbsp;</td>
</tr>
</table>
{/if}

<table class='tabPage' valign='top' width='100%'>
<tr><td>

<span style='background-color:#F2F2F2;display:block;' id='page0'>

<table width=100%>
<tr><td class=tblheader1>Фамилия&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td> <input type=text size=15 name="lname" value="{$lname}"></td></tr>
<tr><td class=tblheader1>Имя</td><td> <input type=text size=15 name="fname" value="{$fname}"></td></tr>
<tr><td class=tblheader1>Отчество</td><td> <input type=text size=15 name="sname" value="{$sname}"></td></tr>
<tr><td class=tblheader1 valign=top>Другие написания ФИО</td>
<td>

<input type=hidden name=delete_spelling value=""/>
<table width=100%>
<colgroup width="200"/><colgroup width="200"/><colgroup width="200"><colgroup width="20"><colgroup width="20">
<tr class=tblheader1><td>Фамилия</td><td>Имя</td><td>Отчество</td><td></td><td></td></tr>

{foreach from=$spelling item=t key=i}
<tr class="tbldata1"}>
<td><input type=hidden name="spelling[{$i}][id]" value="{$t.id}"><input type=text size=30 name="spelling[{$i}][lname]" value="{$t.lname}"></td>
<td><input type=text size=30 name="spelling[{$i}][fname]" value="{$t.fname}"></td>
<td><input type=text size=30 name="spelling[{$i}][sname]" value="{$t.sname}"></td>
<td><input type=checkbox name="spelling[{$i}][disp]" value="1"{if $t.disp} checked{/if}></td>
<td><input type=button value="x" onclick="if(confirm('Удалить написание?')) {literal}{{/literal}document.person.delete_spelling.value={$i};document.person.submit();{literal}}{/literal}"></td>
</tr>
{/foreach}

</table>
<div align=right><input type="submit" name="add_spelling" value="Добавить"/></div>

</td></tr>

<tr><td class=tblheader1>Путь&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td> <input type=text size=15 name="path" value="{$path}"></td></tr>

<tr><td class=tblheader1>Показывать в истории</td><td> <input type="checkbox" name="show_in_history" value="{$show_in_history}"{if $show_in_history=="1"} checked="checked"{/if}></td></tr>
{if $portrait}
<tr>
<td class=tblheader1>Портрет</td>
<td>
<input type="hidden" name="portrait" value="{$portrait}"/>
<input type="hidden" name="portrait_width" value="{$portrait_width}"/>
<input type="hidden" name="portrait_height" value="{$portrait_height}"/>
<input type="hidden" name="thumb_width" value="{$thumb_width}"/>
<input type="hidden" name="thumb_height" value="{$thumb_height}"/>
<a onclick="popup=window.open('/admin/history/portrait.php?src=/history/people/portrait/{$id}.{$portrait}&width={$portrait_width}&height={$portrait_height}','portrait','width={$portrait_width},height={$portrait_height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/people/portrait/{$id}.thumb.{$portrait}" width="{$thumb_width}" height="{$thumb_height}" border="0"/>
</a>
</td></tr>
{/if}
<tr>
<td class=tblheader1>Загрузить{if $portrait} новый{/if} портрет</td>
<td><input type="file" name="portrait_file"></td>
</tr>
{if $portrait}
<tr>
<td class=tblheader1>Удалить портрет</td>
<td><input type="checkbox" name="delete_portrait"></td>
</tr>
{/if}
<tr><td class=tblheader1>Дата рождения (гггг-мм-дд)</td><td> <input type=text size=15 name="birth_date" value="{$birth_date}"></td></tr>
<tr><td class=tblheader1>Дата смерти (гггг-мм-дд)</td><td> <input type=text size=15 name="death_date" value="{$death_date}"></td></tr>
<tr><td class=tblheader1 valign=top>Биографическая справка</td><td>
<div id='div_shortbio'>
            <table border='0' width='100%'><tr><td align='right'>
                &nbsp;&nbsp;<input type='button' onclick='binn_enlargeArea(this, "div_shortbio");' style='font-size:11pt;font-family: Tahoma;width: 24px; height: 24px;' VALUE='+' HIDEFOCUS='true' TITLE='Развернуть'>
            </td></tr></table>
<textarea cols=60 rows=20 name=shortbio>{$shortbio}</textarea>
</div>
</td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>Область научных интересов</td><td><textarea cols=60 rows=10 name=area>{$area}</textarea></td></tr>
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
</table>

</span>

<span style='background-color:#F2F2F2;display:none;' id='page1'>
{section loop=$tree_path name=j}
/<a href="/admin/history/person.php?id={$tree_path[j].id}">{$tree_path[j].lname}&nbsp;{$tree_path[j].fname|initials:0}{$tree_path[j].sname|initials:0}</a>
{/section}
</span>

{if $id}

<span style='background-color:#F2F2F2;display:none;' id='page2'>

{include file="lib/book_list_.tpl" _person=$id}

</span>
<span style='background-color:#F2F2F2;display:none;' id='page3'>

{include file="generic_list.tpl" _picker_href="/admin/history/story_picker.php?" _related="story" _show_delete="1" _delete_name="story_delete" _no_form="1" _form_name="person" _show_checkboxes="1" _checkboxes_name="story_to_delete" _checkboxes_key="id" _show_insert="1" _header="Связанные сюжеты" _rows=$story_list _columns=$story_columns _href="/admin/history/story_list.php?" _item_href="/admin/history/story.php?"}

</span>
<span style='background-color:#F2F2F2;display:none;' id='page4'>

<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class="tblheader"><td colspan="3">Изображения</td></tr>
<colgroup width="20"/><colgroup width="300"/><colgroup width="100%"/>
{if $image}
<tr class="tblheader1"><td width="20">X</td><td width="300">Изображение</td><td>Описание</td></tr>
{foreach from=$image item=i}
<tr class="class={cycle values="tbldata1,tbldata2"}" valign="top">
<td><input type="checkbox" name="image_to_delete[{$i.id}]" value="{$i.ext}"/></td>
<td>
<a onclick="popup=window.open('/admin/history/portrait.php?src=/history/people/portrait/{$id}_image{$i.id}.{$i.ext}&width={$i.width}&height={$i.height}','portrait','width={$i.width},height={$i.height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/people/portrait/{$id}_image{$i.id}.thumb.{$i.ext}" width="{$i.thumb_width}" height="{$i.thumb_height}" border="0"/>
</a>
</td>
<td><textarea rows="5" style="width:80%;" name="image[{$i.id}][descr]">{$i.descr}</textarea></td>
</tr>
{/foreach}
{/if}
<tr class="tblheader"><td colspan="3">Новое изображение</td></tr>
<tr class="tblheader1"><td width="20"></td><td width="300">Файл</td><td>Описание</td></tr>
<tr valign="top"><td></td>
<td><input type="file" name="new_image_file"/></td>
<td><textarea rows="5" name="new_image_descr" style="width:80%"></textarea></td>
</tr>
</table>

</span>
{/if}

</td></tr></table>

<br/>
<table width="100%">
<tr class=tblheader><td colspan="2" align=right>
{if $id && !$image && !$books && !$story && !$tree_path}
<input type=button name="delete" onclick="confirmGo('Удалить персону?', '/admin/history/person.php?delete=1&id={$id}')" value="Удалить">
{/if}
<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/history/person_list.php'" value="К списку"/></td></tr>
</table>


</form>
{include file="footer.tpl"}

{*


{if $mode == 'tree'}
<form name="choose_person" method="post" enctype="multipart/form-data" action="/admin/h_person.php">
<table width=100%>
<tr><td class=tblheader1>Выбрать</td>
<td><input type=hidden name=person_id value="">
<input type=text size=30 name=person_name value="{$person_name}" disabled="1" />
<input type=button name=choose_person value="Выбрать персону..." onClick="popup=window.open('h_tree_personpicker.php?formName=choose_person&elementName=person_id&authorNameElement=person_name&reload=0','personpicker','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;">
&nbsp;&nbsp;&nbsp;<input type='submit' name='addtotree' value='Ok'></td></tr>
</table>
<input type=hidden name=mode value="{$mode}">
<input type=hidden name=pid value="{$pid}">
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
</form>
или
<br/>
<br/>
{/if}

*}