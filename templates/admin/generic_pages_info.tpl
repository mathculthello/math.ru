{if !$_no_form}<form name=paginator method=post style="margin:0 0;">{/if}
{$_p->itemsMessage}: {$_p->itemsNumber}. Показывать на странице: <select name=n onchange="form.submit();">{html_options options=$_p->itemsPerPageOptions selected=$_p->itemsPerPage}</select>
{if !$_no_form}</form>{/if}
