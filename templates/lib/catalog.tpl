{include file="lib/header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{if $search_mode == "all"}
{include file="lib/left.tpl" _path="/lib/cat/"}
{else}
{include file="lib/left.tpl"}
{/if}
</td>
<td id=content valign=top align=center><div>

{if $ser_info}
<h1>Серия "{$ser_info.name}"</h1><br/>
{$ser_info.descr|nl2br}
<hr/>
{elseif $search_mode == "search"}
{include file="lib/search_form.tpl"}
<hr/>
{/if}
{include file="generic/pages.tpl" _info=1}
<hr>
{include file="lib/book_list.tpl"}
<hr>
{include file="generic/pages.tpl" _info=1}<br>

</div></td>
<td id=right valign=top width=150>
{include file="lib/right.tpl"}
</td>
</tr>
{include file="lib/footer.tpl"}