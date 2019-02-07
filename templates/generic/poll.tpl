<form name="{$_poll.name}" method="post" action="{$_action}">
<ol>
{foreach from=$_poll.question item="_q"}
<li>
<div class="pollq">{$_q.title}</div>
<ol>
{foreach from=$_poll.answer[$_q.id] item="_a"}
<li>{if $_q.type == "single"}<input type="radio" name="q[{$_q.id}]" value="{$_a.id}"/>{elseif $_q.type == "multiple"}<input type="checkbox" name="q[{$_q.id}][]" value="{$_a.id}"/>{/if}{$_a.title}</li>
{/foreach}
</ol></li>
{/foreach}
</ol>
<input type="hidden" name="id" value="{$_poll.id}"/>
<table width="100%"><tr><td align="right"><input type="submit" name="send" value="Отправить" class="button"></td></tr></table>
</form>