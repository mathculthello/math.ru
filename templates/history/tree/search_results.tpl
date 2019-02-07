{include file="history/header.tpl"}
<tr>
<td id=menucol valign=top>
{include file="menu.tpl" _path="/history/tree/"}
<img src="/i/p.gif" width=1 height=10><br/>
{include file="lib/alpha.tpl" _href="/history/tree/" _l=$letter} 
<img src="/i/p.gif" width=1 height=10><br/>
{include file="history/tree/search.tpl" _href="/history/tree/"} 
	</td>
	<td id=content valign=top align=center><div>
<h1>Результаты поиска</h1>
{section name=i loop=$search_results}
<a href="/history/tree/{$search_results[i].path}">{$search_results[i].lname}&nbsp;{$search_results[i].fname|initials:1}{$search_results[i].sname|initials:1}&nbsp;{life_date_format birth=$search_results[i].birth_date death=$search_results[i].death_date brackets="p"}</a><br/>
{sectionelse}
{/section}

</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}