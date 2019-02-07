{include file="header.tpl"}
{include file="pages_info.tpl"}
{include file="pages.tpl"}<br>
{section loop=$message name=i}
<b><a href="/admin/pb_message.php?id={$message[i].id}">{$message[i].time} {$message[i].name}</a> {if $message[i].email}(<a href="mailto:{$message[i].email}">{$message[i].email}</a>){/if}</b><br/>
{$message[i].text|nl2br}<br/><br/>
<hr size=1 noshade>
{/section}
<br>
{include file="pages.tpl"}

