{include file="menu.tpl"}
<img src="/i/p.gif" width=1 height=20><br/>
{if $_user_loggedin}
{include file="logout.tpl"}
{else}
{include file="login.tpl"}
{/if}
