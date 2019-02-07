{include file="teacher/header.tpl"}
<tr>
	<td id=menu valign=top>
{include file="menu.tpl"}
	</td>
	<td id=content valign=top align=center><div>
<center>
<h1>{$title}</h1>
</center>
{if $path}<div style="text-align:right;font-weight:bold;"><a href="/teacher/doc/arch/{$path}">Скачать архив ({$size} Кб)</a></div>{/if}
{foreach from=$html_parts item=p key=k}
{if $part == $k+1}
<b>{$p.title}</b>
{else}
<a href="/teacher/doc/{$id}/{$k+1}" class="alink">{$p.title}</a>
{/if}
<br/>
{/foreach}
<hr/>
<br/>
{$text}
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}
