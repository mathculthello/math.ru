{include file="history/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl" _path="/history/stories/"}
	</td>
	<td id=content valign=top align=center><div>
{include file="generic/pages.tpl"}<br/>
{section loop=$story name=i}
<p/>
<b><a href="/history/stories/story.php?id={$story[i].id}">{$story[i].title}</a></b><br/>
<b>{$story[i].source}</b><br/>
{$story[i].text|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"}...<br/><br/>
{/section}
<br/>{include file="generic/pages.tpl"}
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}
