{*
$_ret
*}

<script language="javascript"><!--
{literal}
function setValue(val) {
{/literal}
    opener.document.forms['{$form}'].elements['{$field}'].value = val;
    window.close();
{literal}
}

function setFilter(filter) {
{/literal}
	e = document.forms['filter'].elements['filter'];
    window.location = '{$_href}?path={$dir_info.path}&form={$form}&field={$field}&filter=' + e[e.selectedIndex].value;
{literal}
}
{/literal}
--></script>
{include file="header.tpl" _title=$dir_info.title}
<table border="0" cellspacing="3" cellpadding="2" width="100%">
<form name="filter">
<tr class="tblheader"><td>
Типы файлов:&nbsp;
<select name="filter" onchange="setFilter();">
<option name="" value=""{if !$filter} selected="selected"{/if}>Все файлы (*.*)</option>
<option name="djvu" value="djvu"{if $filter=="djvu"} selected="selected"{/if}>DjVu (*.djvu, *.djv)</option>
<option name="pdf" value="pdf"{if $filter=="pdf"} selected="selected"{/if}>PDF (*.pdf)</option>
<option name="ps" value="ps"{if $filter=="ps"} selected="selected"{/if}>PostScript (*.ps)</option>
<option name="tex" value="tex"{if $filter=="tex"} selected="selected"{/if}>TeX (*.tex)</option>
<option name="html" value="html"{if $filter=="html"} selected="selected"{/if}>HTML (*.html, *.htm)</option>
</select>
</td></tr>
</form>
{foreach from=$dir_info.dirs item=item}
{strip}
<tr class="{cycle values="tbldata1,tbldata2"}">
<td><a href="{$_href}?path={$dir_info.path}{$item}/&form={$form}&field={$field}&filter={$filter}"><img src="/img/fileico_folder.bmp" width="16" height="16" border="0"/>&nbsp;{$item}</a></td>
</tr>
{/strip}
{/foreach}
{foreach from=$dir_info.files item=item}
{strip}
<tr class="{cycle values="tbldata1,tbldata2"}">
<td><a href="" onclick="setValue('{$dir_info.path|substr:1}{$item}');">{$item}</a></td>
</tr>
{/strip}
{/foreach}
<tr class="tblheader"><td align="right"><input type="button" onclick="window.close();" value="Закрыть"/></td></tr>
</table>
