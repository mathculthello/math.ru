{include file="history/header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file="menu.tpl"}
<img src="/i/p.gif" width=1 height=10><br>
{include file="lib/alpha.tpl" _href="/history/people/alph/" _l=$letter} 
<img src="/i/p.gif" width=1 height=10><br>
{include file="history/people/search.tpl"}	
</td>
<td id=content valign=top align=center><div>

{section loop=$person name=p}

{if $smarty.section.p.first || ($person[p].letter != $person[p.index_prev].letter)}

<b>{$person[p].lname|truncate:1:""}</b><br>

{/if}

<a href='/history/people/{$person[p].path}'>{$person[p].lname}&nbsp;{$person[p].fname|initials:1}{$person[p].sname|initials:1}&nbsp;{if $person[p].spelling}({foreach from=$person[p].spelling item=s name=spell}{$s.lname}&nbsp;{$s.fname|initials:1}{$s.sname|initials:1}{if !$smarty.foreach.spell.last},{/if}{/foreach})&nbsp;{/if}{life_date_format birth=$person[p].birth_date death=$person[p].death_date brackets="p"}</a>
<div><img src="/i/p.gif" width="1" height="5"/></div>
{if $smarty.section.p.last || $person[p].letter != $person[p.index_next].letter}
<br><br>
{/if}
{/section}
</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="history/people/footer.tpl"}
