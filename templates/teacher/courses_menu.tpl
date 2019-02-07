<div class=tit4>&nbsp;Курсы повышения &nbsp;квалификации МИОО</div>
<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menu">
{foreach from=$_courses_menu item=m}
{if $m.path == $_path}
<tr><td class=sel><img src="/i/m_u2.gif" width="180" height="4"></td></tr>
<tr id="txt"><td class=sel>{$m.title}</td></tr>
<tr><td class=sel><img src="/i/m_d2.gif" width="180" height="4"></td></tr>
{else}
<tr><td><img src="/i/m_u1.gif" width="180" height="4"></td></tr>
<tr id="txt"><td><a href="{$m.path}">{$m.title}</a></td></tr>
<tr><td><img src="/i/m_d1.gif" width="180" height="4"></td></tr>
{/if}
{/foreach}
</table>

