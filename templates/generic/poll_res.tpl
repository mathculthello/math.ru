Всего проголосовало: {$_poll.votes_num}<br/>
{if $_vote_again}
<form name="{$_poll.name}" method="post" action="{$_action}">
{/if}

<table cellspacing="0" cellpadding="5">
{foreach from=$_poll.question item="_q" key="n"}
<tr><td colspan="3" class="pollq">{math equation="x+1" x=$n}. {$_q.title}</td></tr>
{foreach from=$_poll.answer[$_q.id] item="_a"}
<tr>
<td>
&nbsp;&nbsp;&nbsp;
{if $_vote_again}
{if $_q.type == "single"}<input type="radio" name="q[{$_q.id}]" value="{$_a.id}"{if $_poll.user_result[$_a.id]} checked="checked"{/if}/>{elseif $_q.type == "multiple"}<input type="checkbox" name="q[{$_q.id}][]" value="{$_a.id}" value="{$_a.id}"{if $_poll.user_result[$_a.id]} checked="checked"{/if}/>{/if}
{/if}
{$_a.title}
</td>
<td>
{if $_poll.result[$_a.id]}
<table border="0" cellpadding="0" cellspacing="0">
<tr><td class="pollres"><img src="/i/p.gif" height="6" width="{$_poll.result[$_a.id]}" alt="-" /></td></tr>
</table>
{/if}
</td><td>{if $_poll.result[$_a.id]}
<nobr>{$_poll.result[$_a.id]} ({math equation="x/y*100" x=$_poll.result[$_a.id] y=$_poll.votes_num format="%.0f"}%)</nobr>
{/if}
</td></tr>
{/foreach}
{/foreach}

</table>
{if $_vote_again}
<input type="hidden" name="id" value="{$_poll.id}"/>
<table width="100%"><tr><td align="right"><input type="submit" name="send" value="Отправить" class="button"></td></tr></table>
</form>
{/if}
