{include file="history/header.tpl"}
<tr>
<td id=menucol valign=top  height="85%" width="181">
{include file="menu.tpl"}
<img src="/i/p.gif" width=1 height=10><br>
{include file="lib/alpha.tpl" _href="/history/people/alph/" _l=$letter} 
<img src="/i/p.gif" width=1 height=10><br>
{include file="history/people/search.tpl"}	
</td>
<td id=content valign=top align=center><div>
<center><h1>
<a href="/history/people/{$path}">{$fname|initials:1}{$sname|initials:1}{$lname}</a>
{life_date_format birth=$birth_date death=$death_date brackets="p"}
</h1></center>
<br/><br/>
<table width="100%" cellpadding="10">
{foreach from=$photo item=p key=i name=photo_iter}
{if !($i%2)}
<tr valign="top">
{/if}
<td width="25%">
<a onclick="popup=window.open('/history/people/portrait.php?src=/history/people/portrait/{$id}_image{$p.id}.{$p.ext}&width={$p.width}&height={$p.height}','portrait','width={$p.width},height={$p.height},left=' + ((screen.width-{$p.width})/2) + ',top=' + ((screen.height-{$p.height})/2) + ',scrollbars=no,resizable'); popup.focus(); return false;" href="">
<img src="/history/people/portrait/{$id}_image{$p.id}.thumb.{$p.ext}" width="{$p.thumb_width}" height="{$p.thumb_height}" border="0"/>
</a>
</td>
<td width="25%">{$p.descr}&nbsp;</td>
{if $i%2}
</tr>
{elseif $smarty.foreach.photo_iter.last}
<td width="25%">&nbsp;</td><td width="25%">&nbsp;</td></tr>
{/if}
{/foreach}
</table>
</div></td>
<td id=right valign=top width=150>
{include file="right.tpl"}
</td>
</tr>
{include file="footer.tpl"}


