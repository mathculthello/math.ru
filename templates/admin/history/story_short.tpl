{include file="header.tpl"}
{if $id}
<script language="javascript"><!--
{if $element_name}
opener.document.forms["{$form_name}"].elements["{$element_name}"].value = {$id};
{/if}
{if $text_element_name}
opener.document.forms["{$form_name}"].elements["{$text_element_name}"].value = document.story.elements["title"].value;
{/if}
{if $reload == 1}
opener.document.forms["{$form_name}"].submit();
{/if}
window.close();
--></script>
{else}
{include file="message.tpl"}
<form name=story method=post action="/admin/history/story.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">Добавление сюжета</td></tr>
<tr><td class=tblheader1>Заголовок</td><td><input type=text size=80 name="title" value="{$title}"></td></tr>
<tr><td class=tblheader1 valign="top">Текст</td><td><textarea style="width:100%" cols=60 rows=20 name="text">{$text}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right><input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.close()" value="Закрыть"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=story value=1>
<input type=hidden name=short value=1>
<input type=hidden name="form_name" value="{$form_name}">
<input type=hidden name="element_name" value="{$element_name}">
<input type=hidden name="text_element_name" value="{$text_element_name}">
<input type=hidden name="reload" value="{$reload}">
</form>
{/if}

{include file="footer.tpl"}