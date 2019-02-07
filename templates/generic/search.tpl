{*
_action
_name
_fields
*}
<form method=post action="{$_action}" name="{$_name}">
<table width=100% cellpadding=5>
<tr class=tblheader><td colspan=2>Поиск</td></tr>
{section name=f loop=$_fields}
<tr><td class=tblheader1 align=right>{$_fields[f].title}</td>
<td>{include file="generic/input.tpl" _input=$_fields[f]}</td></tr>
{/section}
<tr><td colspan=2><input type=submit value="Найти"{literal} style="{width:100%;}"{/literal}></td></tr>
</table>
<input type=hidden name=search value=1></form>