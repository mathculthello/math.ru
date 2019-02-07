{include file="header.tpl"}
{foreach from=$rus_letters item=letter key=ord}
<a href="/admin/person_list.php?letter={$ord}">{$letter}</a>
{/foreach}<br/>
{foreach from=$lat_letters item=letter key=ord}
<a href="/admin/person_list.php?letter={$ord}">{$letter}</a>
{/foreach}
<br/><br/>
<input type=button onclick="document.location='/admin/person.php'" value="Добавить">
<br><br>
<table cellpadding=3>
<tr class=tblheader1><td>Фамилия</td><td>Имя</td><td>Отчество</td></tr>
{foreach from=$person item=a}
{strip}
<tr class="{cycle values="tbldata1,tbldata2"}"><td><a href="/admin/person.php?id={$a.id}">{$a.lname}</a></td><td>{$a.fname}</td><td>{$a.sname}</td></tr>
{/strip}
{/foreach}
</table>
