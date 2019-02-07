{include file="header.tpl"}
{if $close}
<script language='javascript'>
window.opener.location="/admin/dic/term.php?id={$term}&tab=2";
window.close();
</script>
{/if}
<table width=100%>
<tr class="tblheader"><td colspan="2">{if $id}Редактирование{else}Добавление{/if} вида формулы</td></tr>
</table>
{include file="generic_message.tpl"}

<form name=contact enctype="multipart/form-data" action="/admin/dic/other_formula.php" method=post>

<table width=100%>

<tr><td class=tblheader1 valign=top>Формула</td><td><textarea cols=60 rows=10 name="formula">{$formula}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Комментарий</td><td><textarea cols=60 rows=10 name="comment">{$comment}</textarea></td></tr>

</table>

<hr>
<div align="right">
<input type=submit name=save value="Сохранить">
<input type=button name=cancel value="Закрыть" onclick="window.close();">
</div>

<input type=hidden name=id value={$id}>
<input type=hidden name=term value={$term}>
<input type=hidden name=other_formula value=1>
</form>

{include file="footer.tpl"}