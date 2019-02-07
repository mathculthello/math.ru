{include file="header.tpl" _title="Выбрать персону"}
{literal}
<script language="javascript"><!--
function returnItem() {
    var f = document.authorpicker;
    if(f.ismultiple && f.idsElementName.value) {
    	for (i = 0; i < f.author.options.length; i++) {
    		if (f.author.options[i].selected) {
			   	opener.document.forms[f.formName.value].elements[f.idsElementName.value].value += " " + f.author.options[i].value;
			}
		}
    } else {
	    if(f.elementName.value)
		    opener.document.forms[f.formName.value].elements[f.elementName.value].value = f.author[f.author.selectedIndex].value;
	    if(f.authorNameElement.value)
    	    opener.document.forms[f.formName.value].elements[f.authorNameElement.value].value = f.author[f.author.selectedIndex].text;
	}
    if(f.reload.value == 1)
        opener.document.forms[f.formName.value].submit();
    window.close();
}
--></script>
{/literal}
<form name=authorpicker method=post>
<input type=hidden name="formName" value="{$formName}">
<input type=hidden name="elementName" value="{$elementName}">
<input type=hidden name="idsElementName" value="{$idsElementName}">
<input type=hidden name="authorNameElement" value="{$authorNameElement}">
<input type=hidden name="reload" value="{$reload}">
<input type=hidden name="ismultiple" value="{$ismultiple}">
<table width=100% height=100%>
<tr class="tblheader" height="30" align="right"><td>Фамилия:&nbsp;<input type=text name=lname value="{$lname}"/><input type=submit value="Найти" style="width:100px;"/></td></tr>
<tr><td width=100% valign="top"><select name=author size=10 style="width:100%;height:100%" onDblClick="returnItem();"{if $ismultiple} multiple="multiple"{/if}>{html_options options=$author_list}</select></td></tr>
<tr class="tblheader" height="60" align="right"><td><input type=button value="Изменить отмеченных" onClick="" style="width:50%;"><input type=button value="Добавить персону" onClick="" style="width:50%;"><br/>
<input type=button value="Выбрать отмеченных" onClick="returnItem();" style="width:50%;"><input type=button value="Закрыть окно" onClick="window.close();" style="width:50%;"></td></tr>
</table></form>

{include file="footer.tpl"}
