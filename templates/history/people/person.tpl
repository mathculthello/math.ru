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
<div>
{include file="history/person_info.tpl"}
</div>
{if $tree_path}
<hr/>
<h1>Древо Лузина</h1>
{include file="history/tree/path.tpl"}
{/if}

{if $books}
<hr/>
<h1>Книги</h1>
{include file="lib/book_list.tpl"}
<br/>
{/if}
{if $story}
<hr/>
<h1>Исторические сюжеты</h1><br/>
{section loop=$story name=i}
<b><a href="/history/stories/story.php?id={$story[i].id}">{$story[i].title}</a></b><br>
<b>{$story[i].source}</b><br>
{$story[i].text}...<br><br>
{/section}
{/if}
</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="history/people/footer.tpl"}
