<div class=tit4>Тематический каталог</div>
<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menu">
{foreach from=$subjects item=s}
{if $s.id == $subj}
<tr><td class=sel><img src="/i/m_u2.gif" width="180" height="4"></td></tr>
<tr id="txt"><td class=sel>{$s.name}</td></tr>
<tr><td class=sel><img src="/i/m_d2.gif" width="180" height="4"></td></tr>
{else}
<tr><td><img src="/i/m_u1.gif" width="180" height="4"></td></tr>
<tr id="txt"><td><a href="/lib/cat/{$s.path}">{$s.name}</a></td></tr>
<tr><td><img src="/i/m_d1.gif" width="180" height="4"></td></tr>
{/if}
{/foreach}
</table>

