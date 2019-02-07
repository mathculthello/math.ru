
{include file="header.tpl"}
{if $save}
<script>
popup=window.open('/admin/lib/ad_tex2png.php?id={$id}','ad_picker','width=800,height=420,left=' + ((screen.width-800)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable');
popup.focus();
</script>
{/if}
{include file="message.tpl"}
<form name="ad" method="post" enctype="multipart/form-data" action="/admin/lib/ad.php">
<table width=100%>
<tr class="tblheader"><td colspan=2>{if $id}Редактирование{else}Добавление{/if} ссылки</td></tr>
<tr><td class=tblheader1 valign=top>Заголовок</td><td><input type=text size="50" name=title value="{$title}"></td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size="50" name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>URL</td><td><input type=text size="50" name=url value="{$url}"></td></tr>
<tr><td class=tblheader1 valign=top>Текст</td><td> <textarea cols=60 rows=10 name="txt">{$txt}</textarea></td></tr>
<tr class="tblheader"><td align=right colspan=2><input type=submit name=save value="Сохранить"/> <input type="button" onclick="document.location='/admin/lib/ad_list.php'" value="К списку"/></td></tr>
</table>
<input type=hidden name=id value="{$id}">
<input type=hidden name=ad value=1>
</form>
{include file="footer.tpl"}
