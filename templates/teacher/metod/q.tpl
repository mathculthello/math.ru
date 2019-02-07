{include file="teacher/header.tpl"}
<tr>
	<td id=menucol valign=top>
{include file="menu.tpl"}
	</td>
	<td id=content valign=top align=center><div>
<br/>
{include file="admin/message.tpl"}
{if $error_message}
{include file="teacher/metod/quest_form.tpl"}
{/if}
	</div></td>
	<td id=right valign=top><img src="i/p.gif" width=1 height=7><br>
	{include file="news.tpl"}
	</td>
</tr>
{include file="footer.tpl"}