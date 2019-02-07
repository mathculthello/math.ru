{include file="header.tpl"}
{if $ad && $id && ($element_name || $text_element_name)}
<script language="javascript"><!--
{if $element_name}
opener.document.forms["{$form_name}"].elements["{$element_name}"].value = {$id};
{/if}
{if $text_element_name}
opener.document.forms["{$form_name}"].elements["{$text_element_name}"].value = document.ad.elements["title"].value;
{/if}
{if $reload == 1}
opener.document.forms["{$form_name}"].submit();
{/if}
//window.close();
window.location="/admin/lib/ad_tex2png.php?id={$id}";
--></script>
{else}
{include file="message.tpl"}
<form name="ad" method="post" enctype="multipart/form-data" action="/admin/lib/ad.php">
<table width=100%>
<tr class="tblheader"><td colspan=2>{if $id}Редактирование{else}Добавление{/if} отрывка</td></tr>
<tr><td class=tblheader1 valign=top>Страница</td><td><input type=text name=page value="{$page}"></td></tr>
<tr><td class=tblheader1 valign=top>Смещение</td><td><input type=text name=shift value="{$shift|default:$djvu_shift}"></td></tr>
<tr><td class=tblheader1 valign=top>Текст</td><td> <textarea cols=60 rows=10 name="txt">{$txt}</textarea></td></tr>
<tr class="tblheader"><td align=right colspan=2><input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.close()" value="Закрыть"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=book_id value="{$book_id}">
<input type=hidden name=ad value=1>
<input type=hidden name=short value=1>
<input type=hidden name="form_name" value="{$form_name}">
<input type=hidden name="element_name" value="{$element_name}">
<input type=hidden name="text_element_name" value="{$text_element_name}">
<input type=hidden name="reload" value="{$reload}">
</form>
{/if}
{include file="footer.tpl"}
