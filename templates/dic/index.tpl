{include file="dic/header.tpl"}
<tr>
	<td id=menucol valign=top>
{if $_p->pagesNumber > 1}
<div class="pager">
<table width="100%" cellpadding="0" cellspacing="0" border="0">
<tr>
<td>
{if $_p->page != 1}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page=1&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}" alt="В начало списка">&lt;&lt;</a>{/if}
{if $_p->prevPages}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->prevPages}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">...</a>{/if}
{foreach from=$_p->pages item=page name=i}{if $page != $_p->page}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$page}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">{$page}</a>{else}<b>{$page}</b>{*{if !$smarty.foreach.i.last}|{/if}*}{/if}{/foreach}
{if $_p->nextPages}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->nextPages}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}">...</a> {/if}
{if $_p->page != $_p->pagesNumber}<a href="{$_p->href}?n={$_p->itemsPerPage}&amp;page={$_p->pagesNumber}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}{$_get}" alt="В конец списка"> &gt;&gt; </a> {/if}
</td>
</tr>
</table>
</div>
{/if}
{include file="dic/words.tpl"}
	</td>
	<td id=content valign=top align=center><div>
{if $rubr_path}
<br/>
{include file="dic/rubr_path.tpl"}
<hr size="1" noshade="noshade"/>
{/if}
{if $term_info}
{include file="dic/term_info.tpl"}
{else}
{include file="dic/rubr.tpl"}
{/if}
	</div></td>
	<td id=right valign=top><img src="/i/p.gif" width=1 height=7><br>
{include file="dic/right.tpl"}
	</td>
</tr>
{include file="dic/footer.tpl"}
