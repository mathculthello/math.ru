<table width="100%" cellpadding="10" cellspacing="0"><tr><td>
{if $portrait}
<table align="left" valign="top"><tr><td>
<a onclick="popup=window.open('/history/people/portrait.php?src=/history/people/portrait/{$id}.{$portrait}&width={$portrait_width}&height={$portrait_height}','portrait','width={$portrait_width},height={$portrait_height},left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/people/portrait/{$id}.thumb.{$portrait}" width="{$thumb_width}" height="{$thumb_height}" style="margin-right:10;margin-bottom:10;margin-top:10;" border="0">
</a>
{if $photo}
<br/>
<center><a href="/history/people/photo/{$path}">Фотографии</a></center>
{/if}
</td></tr></table>
{/if}
<center><h1>
{if $show_in_history}<a href="/history/people/{$path}">{$fname|initials:1}{$sname|initials:1}{$lname}</a>
{else}{$fname|initials:1}{$sname|initials:1}{$lname}{/if}<br/>
{life_date_format birth=$birth_date death=$death_date brackets="p"}
</h1></center>
<div align=right>{$source}</div>
<p align="justify"/>{$shortbio|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"}<br><br>
{$area}<br/><br/>
</td></tr></table>
