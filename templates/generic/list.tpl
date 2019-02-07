{*
$_columns
$_p - paginator
$_rows
$_href ?&
$_item_href
*}

<table border=0 cellspacing=3 cellpadding=2 width=100%>
<tr class=tblheader1>
{foreach from=$_columns item=c}
<td>{if $c.ordered}{if $_p->orderBy == $c.name}<img src="/img/sort{$c.order}.gif" width=16 height=16 />{/if}<a href="{$_href}n={$_p->itemsPerPage}&p=1&o_by={$c.name}&o={$c.order}">{$c.title}</a>{else}{$c.title}{/if}</td>
{/foreach}
</tr>
{foreach from=$_rows item=r}{strip}
<tr class="{cycle values="tblrow1,tblrow2"}">{foreach from=$_columns item=c}<td{if $c.width} width={$c.width}{/if}>{if $c.ref}<a href="{$_item_href}?id={$r.id}">{$r[$c.name]}</a>{else}{$r[$c.name]}{/if}</td>{/foreach}</tr>
{/strip}{/foreach}
</table>