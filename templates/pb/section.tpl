<div class="tit4">Разделы</div>
<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menutable">
{foreach from=$section item=s}
<tr><td{if $s.id == $sid} class="select"{/if}><a href="/pb/index.php?sid={$s.id}">{$s.name}</a></td></tr>
{/foreach}
</table>
