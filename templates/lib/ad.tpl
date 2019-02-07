<table width="100%" cellpadding=1 cellspacing=0 border=0><tr><td bgcolor="#6C6C6C" width="100%">
<table width="100%" cellpadding=5 cellspacing=0 border=0 bgcolor="FCF8F5">
<tr><th class=tit1>Интересная книга</th></tr>
<tr><td valign=top>
<div>
<a href="/lib/files/{$ad.path}?djvuopts&page={$ad.page+$ad.shift}">
{$ad.txt|nl2br}
</a>
</div>
</td></tr>
<tr><td valign=bottom>
<div align=right>
<a href="/lib/book/{$ad.path}">{foreach from=$ad.author item=a name=authors}{$a.fname|initials}{$a.sname|initials}{$a.lname}{if !$smarty.foreach.authors.last},&nbsp;{/if}{/foreach}&nbsp;&nbsp;"{$ad.title}"</a>
</div>
</td></tr></table>
</td></tr></table>


{*
<TABLE WIDTH=100% BORDER=0 CELLPADDING=1 CELLSPACING=0 CLASS=box1>
<TR>
<TD>
<TABLE WIDTH=100% BORDER=0 CELLPADDING=2 CELLSPACING=0>
<TR class=box1><TD ALIGN=center CLASS=boxtitle>Книга дня</TD></TR>
<tr><td>{$ad.txt}</td></tr>
</TABLE>
</TD>
</TR>
</TABLE>
*}