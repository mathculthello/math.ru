<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td bgcolor="#006699"><table border="0" cellpadding="1" cellspacing="1"  width="100%">
<tr><td bgcolor="#ffffff"><table border="0" cellpadding="10" cellspacing="0"  width="100%">
<tr><td width="100%">
{foreach from=$section item=s}
{if $s.id neq $sid}<a href="/pb/index.php?sid={$s.id}">{$s.name}</a>{else}<b>{$s.name}</b>{/if}<br/>
{/foreach}
</td></tr></table></td></tr></table></td></tr></table>
