<table border=0 cellPadding=0 cellSpacing=6 width=100%><tr>
<td valign=top><table width=100% cellpadding=10><tr><td width=100%><br>
{if $portrait}
<a onclick="popup=window.open('/admin/history/portrait.php?src=/history/people/portrait/{$id}.{$portrait}&width={$portrait_width}&height={$portrait_height}','portrait','width={$portrait_width},height={$portrait_height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/people/portrait/{$id}.thumb.{$portrait}" width="{$thumb_width}" height="{$thumb_height}" align=left style="margin-right:10;margin-bottom:10;"/>
</a>
{/if}
<center><h2>{$fullname}</h2></center>
<div align=right>{$source}</div>
{$shortbio}<br><br>
{$area}<br><br>
</td></tr></table>
</td></tr></table>
