<table width=100% cellpadding=10><tr><td width=100%><br>
{if $person.portrait}<img src="/history/people/portrait/{$person.id}.{$person.portrait_type}" width="{$person.portrait_width}" height="{$person.portrait_height}" align=left style="margin-right:10;margin-bottom:10;">{/if}
<center><h1>{$person.fullname}</h1></center>
<div align=right>{$person.source}</div>
{$person.shortbio}<br><br>
</td></tr></table>