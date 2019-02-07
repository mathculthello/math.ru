{include file="history/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl"}
	</td>
	<td id=content valign=top align=center><div>
<h1>{$title}</h1>
<div align=right>{$source}</div>
<br/><br/>
{$text|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"}
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}