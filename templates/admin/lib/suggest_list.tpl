{include file="header.tpl"}
<br><br>
{include file="pages.tpl"}<br>
<table width=100%><tr class=tblheader1><td width=100>Дата</td><td>Книга</td><td>От кого</td></tr>
{section loop=$suggest name=i}
<tr valign=top class="{cycle values="tbldata1,tbldata2"}"><td>{$suggest[i].date}</td>
<td>{$suggest[i].title}<br>{$suggest[i].author}<br>{$suggest[i].publ}<br>{$suggest[i].info}</td>
<td>{$suggest[i].name}<br>{$suggest[i].occupation}<br>{$suggest[i].job}<br>{$suggest[i].contacts}</td>
{/section}
</table>
<br>{include file="pages.tpl"}
