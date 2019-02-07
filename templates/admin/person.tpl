{include file="header.tpl"}
{if $error_message}<span class=error>{section name=i loop=$error_message}Ошибка: {$error_message[i]}<br>{/section}</span>
{elseif $message}<span class=msg>{$message}</span>{/if}
<form name="person" method="post" enctype="multipart/form-data" action="/admin/person.php">
<table width=100%>
<tr class=tblheader1><td>{if $id} <input type=submit name=remove value="удалить">{/if}</td><td align=right><input type=submit name=save value="сохранить"></td></tr>
{if !$id}
{literal}
<script language="javascript"><!--
function setNew(option) {
    var f = document.person;
    switch(option) {
        case 0:
            f.fname.disabled = true;
            f.sname.disabled = true;
            f.lname.disabled = true;
            f.chooseauthor.disabled = false;
            break;
        case 1:
            f.fname.disabled = false;
            f.sname.disabled = false;
            f.lname.disabled = false;
            f.chooseauthor.disabled = true;
    }
}
-->
</script>
{/literal}
<tr><td class=tblheader1><input type=radio name=isnew value=1 checked onclick="setNew(1)";>Новая персона</td><td>
Фамилия: <input type=text size=15 name="lname" value="{$lname}">
Имя: <input type=text size=15 name="fname" value="{$fname}">
Отчество: <input type=text size=15 name="sname" value="{$sname}"></td></tr>
<tr><td class=tblheader1><input type=radio name=isnew value=0 onclick="setNew(0)";>Автор из каталога библиотеки</td><td><input type=hidden name=author value=""><input type=text size=30 name="authorname" value="{$authorname}" disabled><input type=button name=chooseauthor value="Выбрать автора..." disabled onClick="popup=window.open('authorpicker_nobio.php?formName=person&elementName=author&authorNameElement=authorname&reload=0','authorpicker','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;"></td></tr>
{else}
<tr><td class=tblheader1>Фамилия:</td><td> <input type=text size=15 name="lname" value="{$lname}"></td></tr>
<tr><td class=tblheader1>Имя:</td><td> <input type=text size=15 name="fname" value="{$fname}"></td></tr>
<tr><td class=tblheader1>Отчество:</td><td> <input type=text size=15 name="sname" value="{$sname}"></td></tr>
{/if}
<tr><td class=tblheader1>Портрет</td><td>{if $portrait}<img src="/history/people/portrait/{$id}.{$portrait_type}" width="{$portrait_width}" height="{$portrait_height}"><br><br>{/if}загрузить: <input type="file" name="portrait_file"></td></tr>
<tr><td class=tblheader1 valign=top>Биографическая справка</td><td><textarea cols=60 rows=20 name=shortbio>{$shortbio}</textarea></td></tr>
<tr><td class=tblheader1 valign=top>Источник</td><td><input type=text size=80 name=source value="{$source}"></td></tr>
<tr><td class=tblheader1 valign=top>Очерки</td><td>
{if $story}<table cellspacing=0 cellpadding=0>
{foreach from=$story item=s}<tr><td><input type=checkbox name="removeStoryID[{$s.id}]"></td><td><input type=hidden name="storyID[]" value="{$s.id}">{$s.title}</td></tr>{/foreach}
<tr><td colspan=2><input type=submit style="width:200px;" name=removeStory value="удалить отмеченные"></td></tr>
</table><br>{/if}
<input type=hidden name=newStoryID value=0>
<input type=button style="width:200px;" value="добавить" onClick="popup=window.open('storypicker.php?formName=person&elementName=newStoryID&reload=1','storypicker','width=420,height=420,left=' + ((screen.width-420)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=no,resizable'); popup.focus(); return false;">
</td></tr>
<tr class=tblheader1><td>{if $id} <input type=submit name=remove value="удалить">{/if}</td><td align=right><input type=submit name=save value="сохранить"></td></tr>
<input type=hidden name=id value="{$id}">
<input type=hidden name=person value=1>
</table>
</form>