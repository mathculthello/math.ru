{include file="header.tpl"}
<tr>
	<td id=menu valign=top>
{include file="menu.tpl"}
	</td>
	<td id=content valign=top align=center><div>
<h1>{$title}</h1>
<div align=right>{$source}</div>
<br/><br/>
{$txt|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"}
<hr>
<table valign=bottom width=100% border=0><tr><td>
{if $topic}
<a href="/forum/viewtopic.php?t={$topic}" class="alink">Обсудить на форуме</a>
{/if}
</td><td align=right>
{if $path}
<a href="/teacher/article/{$path}"><img src="/i/load.gif" width=89 height=17 border=0 alt="Скачать"></a>
{/if}
</td></tr></table>
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}