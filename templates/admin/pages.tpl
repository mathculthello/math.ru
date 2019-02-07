{if $_p->pagesNumber > 1}
<div class=pages>
Страницы:
{if $_p->page != 1} <a href="{$_p->href}?n={$_p->itemsPerPage}&page=1&o={$_p->order}&o_by={$_p->orderBy}" alt="В начало списка">&laquo;</a>{/if}
{if $_p->prevPages} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->prevPages}&o={$_p->order}&o_by={$_p->orderBy}">...</a>{/if}
{foreach from=$_p->pages item=page name=i}
{if $page != $_p->page}
 <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$page}&o={$_p->order}&o_by={$_p->orderBy}">{$page}</a>
<!--{if !$smarty.foreach.i.last}|{/if}-->
{else}
<span class=currentpage> {$page} </span><!--{if !$smarty.foreach.i.last}|{/if}-->
{/if}
{/foreach}
{if $_p->nextPages} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->nextPages}&o={$_p->order}&o_by={$_p->orderBy}">...</a> {/if}
{if $_p->page != $_p->pagesNumber} <a href="{$_p->href}?n={$_p->itemsPerPage}&page={$_p->pagesNumber}&o={$_p->order}&o_by={$_p->orderBy}" alt="В конец списка"> &raquo; </a> {/if}
</div>
{/if}
