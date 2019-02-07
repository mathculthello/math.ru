<div class=tit4>Серии книг</div>

<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menu">
{foreach from=$series item=s}
{if $s.id == $ser}
<tr><td class=sel><img src="/i/m_u2.gif" width="180" height="4"></td></tr>
<tr id="txt"><td class=sel>{$s.name}</td></tr>
<tr><td class=sel><img src="/i/m_d2.gif" width="180" height="4"></td></tr>
{else}
<tr><td><img src="/i/m_u1.gif" width="180" height="4"></td></tr>
<tr id="txt"><td><a href="/lib/ser/{$s.path}">{$s.name}</a></td></tr>
<tr><td><img src="/i/m_d1.gif" width="180" height="4"></td></tr>
{/if}
{/foreach}
</table>
{*
{foreach from=$series item=s}
{if $s.id == $ser}{$s.name}{else}<a href="/lib/ser/{$s.path}">{$s.name}</a>{/if}<br/>
{/foreach}
*}