<table width=100% cellpadding=0 cellspacing=0 border=0 id=pages>
<tr><td>
<form name="paginator" method="post"><input type="hidden" name="page" value="1"/>
{$_p->itemsMessage}: {$_p->itemsNumber}. Показывать на странице: <select  style="border: solid 1px #6C6C6C; font: 10px; color: #3464B6" name="n" onchange="form.submit();">{html_options options=$_p->itemsPerPageOptions selected=$_p->itemsPerPage}</select>
</form>
</td>
	</tr>
</table>