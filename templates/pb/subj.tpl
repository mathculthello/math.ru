<div class="tit4">Тематический каталог</div>
<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menutable">
{foreach from=$subject item=s}
<tr><td{if $s.id == $subj} class="select"{/if}><a href="/pb/index.php?subj={$s.id}">{$s.name}</a></td></tr>
{/foreach}
</table>
