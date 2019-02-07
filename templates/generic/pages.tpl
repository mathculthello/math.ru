{*
$_p
$_info
*}
<table width="100%" cellpadding="0" cellspacing="0" border="0" id="pages">
<tr>
{if $_p->pagesNumber > 1}
<td>
{if $_p->page != 1}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page=1&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}" alt="В начало списка">&lt;&lt;</a>{/if}
{if $_p->prevPages}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->prevPages}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">...</a>{/if}
{foreach from=$_p->pages item=page name=i}{if $page != $_p->page}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$page}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">{$page}</a>{else}<b>{$page}</b>{*{if !$smarty.foreach.i.last}|{/if}*}{/if}{/foreach}
{if $_p->nextPages}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->nextPages}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">...</a> {/if}
{if $_p->page != $_p->pagesNumber}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->pagesNumber}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}" alt="В конец списка"> &gt;&gt; </a> {/if}
</td>
{/if}
{if $_info}
<td align="right">
<form name="paginator" method="post"><input type="hidden" name="page" value="1"/>
{$_p->itemsMessage}: {$_p->itemsNumber}. Показывать на странице: <select  style="border: solid 1px #6C6C6C; font: 10px; color: #3464B6" name="n" onchange="form.submit();">{html_options options=$_p->itemsPerPageOptions selected=$_p->itemsPerPage}</select>
</form>
</td>
{/if}
</tr>
</table>