{include file="header.tpl"}
{if $id}
<script language="javascript"><!--
{if $element_name}
opener.document.forms["{$form_name}"].elements["{$element_name}"].value = {$id};
{/if}
{if $text_element_name}
opener.document.forms["{$form_name}"].elements["{$text_element_name}"].value = document.story.elements["title"].value;
{/if}
{if $reload == 1}
opener.document.forms["{$form_name}"].submit();
{/if}
window.close();
--></script>
{else}
{include file="message.tpl"}
<form name="person" method="post" enctype="multipart/form-data" action="/admin/history/person.php">
<table width=100%>
<tr class="tblheader"><td colspan="2">Добавление персоны</td></tr>
<tr><td class=tblheader1>Фамилия&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td> <input type=text size=15 name="lname" value="{$lname}"></td></tr>
<tr><td class=tblheader1>Имя</td><td> <input type=text size=15 name="fname" value="{$fname}"></td></tr>
<tr><td class=tblheader1>Отчество</td><td> <input type=text size=15 name="sname" value="{$sname}"></td></tr>
<tr><td class=tblheader1>Путь&nbsp;<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td> <input type=text size=15 name="path" value="{$path}"></td></tr>
<tr><td class=tblheader1>Дата рождения (гггг-мм-дд)</td><td> <input type=text size=15 name="birth_date" value="{$birth_date}"></td></tr>
<tr><td class=tblheader1>Дата смерти (гггг-мм-дд)</td><td> <input type=text size=15 name="death_date" value="{$death_date}"></td></tr>
<tr class="tblheader"><td colspan="2" align=right><input type=submit name=save value="Сохранить"/> <input type="button" onclick="window.close()" value="Закрыть"/></td></tr>
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
<input type=hidden name=short value=1>
<input type=hidden name="form_name" value="{$form_name}">
<input type=hidden name="element_name" value="{$element_name}">
<input type=hidden name="text_element_name" value="{$text_element_name}">
<input type=hidden name="reload" value="{$reload}">
</table>
</form>
{/if}
{include file="footer.tpl"}
