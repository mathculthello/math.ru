{*
_href ? &
*}

{foreach from=$rus_letters item=letter key=ord}
<a href="{$_href}letter={$ord}">{$letter}</a>
{/foreach}<br/>
{foreach from=$lat_letters item=letter key=ord}
<a href="{$_href}letter={$ord}">{$letter}</a>
{/foreach}
