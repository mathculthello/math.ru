{*
$_p
$_get &
*}

{if $_p->pagesNumber > 1}
<div id=abc>
Страницы:
{if $_p->page != 1} <a href="{$_p->href}?n={$_p->itemsPerPage}&page=1&o={$_p->order}&o_by={$_p->orderBy}{$_get}" alt="В начало списка">&laquo;</a>{/if}
{if $_p->prevPages} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->prevPages}&o={$_p->order}&o_by={$_p->orderBy}{$_get}">...</a>{/if}
{foreach from=$_p->pages item=page name=i}
 <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$page}&o={$_p->order}&o_by={$_p->orderBy}{$_get}"{if $page == $_p->page} class=select{/if}>{$page}</a>
{/foreach}
{if $_p->nextPages} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->nextPages}&o={$_p->order}&o_by={$_p->orderBy}{$_get}">...</a> {/if}
{if $_p->page != $_p->pagesNumber} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->pagesNumber}&o={$_p->order}&o_by={$_p->orderBy}{$_get}" alt="В конец списка"> &raquo; </a> {/if}
</div>
{/if}