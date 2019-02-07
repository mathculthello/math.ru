{include file="header.tpl"}
<form name=problem method=post action="/admin/tex2png/tex2png.php">
<table width=100%>
<tr><td class=tblheader1 valign=top>TeX</td><td><textarea name="tex" cols=80 rows=20>{$tex}</textarea></td></tr>
<tr><td colspan=2>
<input type=radio name="mode" value="all"{if $mode eq 'all'} checked{/if}> Одна картинка <input type=radio name="mode" value="small"{if $mode neq 'all'} checked{/if}> HTML + картинки для формул</td></tr>
<tr><td colspan=2 align=right><input type=submit></td></tr>
</table>
</form>
<hr size=1 noshade>
{$html|nl2br}