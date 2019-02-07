{include file="header.tpl"}
{if $close}
<script language='javascript'>
window.opener.location="/admin/dic/term.php?id={$term}&tab=1";
window.close();
</script>
{/if}
{if $type != 'formula'}
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} определения</td></tr>
</table>
{/if}
{include file="generic_message.tpl"}

<form name=contact enctype="multipart/form-data" action="/admin/dic/wording.php" method=post>

{if $type == 'formula'}
<table width=100%>
<tr><td class=tblheader1 valign=top>Учебник</td><td>
введите
<input type="text" size="32" name="src_code" value="{$src_options[$src]}">
или выберите
<select name="src">
<option value="0" label="---">---</option>
{html_options options=$src_options selected=$src}</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Комментарий</td><td><textarea cols=60 rows=10 name=comment>{$comment}</textarea></td></tr>
</table>
{else}
<table width=100%>
<tr><td class=tblheader1 valign=top>Определение</td><td><textarea cols=60 rows=10 name=wording>{$wording}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Комментарий</td><td><textarea cols=60 rows=10 name=comment>{$comment}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Код источника</td><td>
введите
<input type="text" size="32" name="src_code" value="{$src_options[$src]}">
или выберите
<select name="src">
<option value="0" label="---">---</option>
{html_options options=$src_options selected=$src}</select>
</td></tr>
</table>
{/if}
<hr>
<div align="right">
<input type=submit name=save value="Сохранить">
<input type=button name=cancel value="Закрыть" onclick="window.close();">
</div>

<input type=hidden name=id value={$id}>
<input type=hidden name=term value={$term}>
<input type=hidden name=type value={$type}>
<input type=hidden name=def value=1>
</form>

{include file="footer.tpl"}