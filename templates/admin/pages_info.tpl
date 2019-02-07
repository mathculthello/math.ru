<form name=paginator method=post><input type=hidden name=page value=1>
{$_p->itemsMessage}: {$_p->itemsNumber}. Показывать на странице: <select name=n onchange="form.submit();">{html_options options=$_p->itemsPerPageOptions selected=$_p->itemsPerPage}</select>
</form>
