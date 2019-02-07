{include file="header.tpl"}
{include file="message.tpl"}

<form name=term method=post action="/admin/dic/term.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} {if $type == "fact"}факта{elseif $type == "formula"}формулы{elseif $type == "term"}понятия{/if}</td></tr>
</table>
<div align="right">
<tr class="tblheader"><td colspan="2" align=right>{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/dic/term_list.php?page={$page}&type={$type}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/></td></tr>
</div>
<hr>
{if $id}
<table width=100% align='center' cellspacing='0' cellpadding='0' border='0'>
<tr>
<td style='padding-right: 2px;'>
<input class='{if !$tab || $tab==0}tabOn{else}tabOff{/if}' id='tab0' type='button' value='{if $type == "fact"}Факт{elseif $type == "formula"}Формула{else}Понятие{/if}' onclick='showTabPage(0,6);document.term.tab.value=0;'>
</td>
<td style='padding-right: 2px;'>
<input class='{if $tab==1}tabOn{else}tabOff{/if}' id='tab1' type='button' value='встречается в учебниках...' onclick='showTabPage(1,6);document.term.tab.value=1;'>
</td>
<td style='padding-right: 2px;'>
<input class='{if $tab==2}tabOn{else}tabOff{/if}' id='tab2' type='button' value='Другие виды формулы' onclick='showTabPage(2,6);document.term.tab.value=2;'>
</td>
<td style='padding-right: 2px;'>
<input class='tabOff' id='tab3' type='button' value='Рубрикатор' onclick='showTabPage(3,6);document.term.tab.value=3;'>
</td>
<td style='padding-right: 2px;'>
<input class='{if $tab==4}tabOn{else}tabOff{/if}' id='tab4' type='button' value='Связаные статьи' onclick='showTabPage(4,6);document.term.tab.value=4;'>
</td>
<td style='padding-right: 2px;'>
<input class='{if $tab==5}tabOn{else}tabOff{/if}' id='tab5' type='button' value='История изменений' onclick='showTabPage(5,6);document.term.tab.value=5;'>
</td>
<td width='100%'>&nbsp;</td>
</tr>
</table>

<table class='tabPage' valign='top' width='100%'>
<tr><td>

<span style='background-color:#F2F2F2;display:{if !$tab || $tab==0}block{else}none{/if};' id='page0'>
{/if}

<table>
<tr><td class=tblheader1>{if $type == "fact"}Название факта{elseif $type == "formula"}Название формулы{elseif $type == "term"}Название понятия{/if}</td><td>
<input type=text size=80 name="title" value="{$title}">
</td></tr>

<tr><td class=tblheader1 valign=top>Формула</td><td>
<textarea cols=60 rows=10 name="comment">{$comment}</textarea>
</td></tr>

<tr><td class=tblheader1 valign=top>{if $type == "fact" || $type == "formula"}Математически верная формулировка{else}Математически верное определение{/if}</td><td>
<textarea cols=60 rows=10 name="formula">{$formula}</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>Код источника</td><td>
введите
<input type="text" size="32" name="src_formula_code" value="{$src_options[$src_formula]}">
или выберите
<select name="src_formula"><option value="0" label="---">---</option>{html_options options=$src_options selected=$src_formula}</select>
</td></tr>

<tr><td class=tblheader1 valign=top>Словарная статья</td><td>
<textarea cols=60 rows=10 name="entry">{$entry}</textarea>
</td></tr>
<tr><td class=tblheader1 valign=top>Код источника</td><td>
введите
<input type="text" size="32" name="src_entry_code" value="{$src_options[$src_entry]}">
или выберите
<select name="src_entry">
<option value="0" label="---">---</option>
{html_options options=$src_options selected=$src_entry}</select>
</td></tr>

<tr><td class=tblheader1>Ключевые слова</td><td>
<textarea name="keywords" cols="60">{$keywords}</textarea>
</td></tr>

<tr><td class=tblheader1 width="250">Классы</td><td>
<select name="grade[]" style="width:40px;" multiple="multiple" size="7">
{html_options options=$grade_options selected=$grade}
</select>
</td></tr>


</table>

{if $id}
</span>

<span style='background-color:#F2F2F2;display:{if $tab==1}block{else}none{/if};' id='page1'>

{include file="generic_list.tpl" _rows=$def _columns=$def_columns _show_insert="1" _href="/admin/dic/wording.php?term=$id&type=formula&" _related="wording" _picker_href="/admin/dic/wording.php?term=$id&type=formula&" _delete_column="1" _delete_message="Удалить?" _delete_href="/admin/dic/term.php?id=$id&tab=1&del_wording=" _no_form="1"}

</span>
<span style='background-color:#F2F2F2;display:{if $tab==2}block{else}none{/if};' id='page2'>

{include file="generic_list.tpl" _rows=$other_formula _columns=$formula_columns _show_insert="1" _href="/admin/dic/other_formula.php?term=$id&" _related="other_formula" _picker_href="/admin/dic/other_formula.php?term=$id&" _delete_column="1" _delete_message="Удалить формулу?" _delete_href="/admin/dic/term.php?id=$id&tab=2&del_formula=" _no_form="1"}

</span>

<span style='background-color:#F2F2F2;display:none;' id='page3'>
{foreach from=$rubr_list item=s key=i}
{""|indent:$s.level-1:"&nbsp;&nbsp;&nbsp;&nbsp;"}<input type="checkbox" name="rubr[{$i}]" value="{$i}"{if $s.checked} checked="checked"{/if}/>{$s.name}<br/>
{/foreach}
</span>

<span style='background-color:#F2F2F2;display:{if $tab==4}block{else}none{/if};' id='page4'>

<table width=100%>
{foreach from=$references item=r key=i}
<tr>
<td onmouseup='press(false)' onmousedown='press(true)' onmouseover='hover(true)' onmouseout='hover(false)' style='cursor: default'>
<input type="hidden" name="references[{$i}][id]" value="{$r.id}">
<nobr>
<input type=text size="40" name="references[{$i}][title]" value="{$r.title}"/>
<a href="#" title="Выбрать статью" onclick="popup=window.open('/admin/dic/term_picker.php?form_name=term&element_name=references[{$i}][id]&text_element_name=references[{$i}][title]','_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
<img class=button align='absbottom' style='cursor: hand;' src="/i/browse.png" border=0 width=16 height=16></a>
</nobr>
</td>
<td><input type=button value="x" onclick="if(confirm('Удалить ссылку?')) {literal}{{/literal}document.term.delete_ref.value={$i};document.term.submit();{literal}}{/literal}"></td>
</tr>
{/foreach}
</table>
<div class=tbldata1 align=right><input type="submit" onclick="document.term.tab.value=4;" name="add_ref" value="Добавить ссылку"/></div>

</span>

<span style='background-color:#F2F2F2;display:{if $tab==5}block{else}none{/if};' id='page5'>

<table width=100%>
{foreach from=$history item=h key=i}
<tr>
<td>{$h.ts|date_format:'%d.%m.%Y %H:%M'}</td><td>{$h.login}</td>
</tr>
{/foreach}
</table>

</span>

{/if}

</td></tr></table>
<hr>
<div align="right">
{if $id} <input type=submit name=delete value="Удалить"/>{/if}<input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.location='/admin/dic/term_list.php?type={$type}&page={$page}&o_by={$o_by}&o={$o}&n={$n}'" value="К списку"/>
</div>

<input type=hidden name=delete_ref value="">
<input type=hidden name=wording_to_insert value="">
<input type=hidden name=comp_to_insert value="">
<input type=hidden name=id value="{$id}">
<input type=hidden name=type value="{$type}">
<input type=hidden name=tab value="{$tab}">
<input type=hidden name=term value=1>

</form>
