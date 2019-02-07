{include file="header.tpl" _title=$picker.title}
{literal}
<script language="javascript"><!--
function insertLink(element, lnk, txt) {
    //IE support
    if (opener.document.selection) {

        element.focus();
        sel = opener.document.selection.createRange();
        if (sel.text)
        {
        	sel.text = "<a href=\"" + lnk + "\">" + sel.text + "</a>";
        }
        else
        {
        	sel.text = "<a href=\"" + lnk + "\">" + txt + "</a>";
        }
    }
    //MOZILLA/NETSCAPE support
    else if (element.selectionStart || element.selectionStart == "0") {
        var startPos = element.selectionStart;
        var endPos = element.selectionEnd;
        element.value = element.value.substring(0, startPos) +
        "<a href=\"" + lnk + "\">" + ((startPos != endPos) ? element.value.substring(startPos, endPos) : txt ) + "</a>" +
        element.value.substring(endPos, element.value.length);
    } else {
        element.value += "<a href=\"" + lnk + "\">" + txt + "</a>";
    }
}


function returnItem() {
    var f = document.picker;
    if (f.ismultiple.value == 1) {
    	for (i = 0; i < f.items.options.length; i++) {
    		if (f.items.options[i].selected) {
			   	opener.document.forms[f.form_name.value].elements[f.element_name.value].value += " " + f.items.options[i].value;
			}
		}
    } else {
	    if (f.element_name.value)
		    opener.document.forms[f.form_name.value].elements[f.element_name.value].value = f.items[f.items.selectedIndex].value;
	    if (f.text_element_name.value)
	    {
	        if (f.insert_link.value)
	        {
    	    	insertLink(opener.document.forms[f.form_name.value].elements[f.text_element_name.value],
    	    	f.insert_link.value + f.items[f.items.selectedIndex].value, f.items[f.items.selectedIndex].text);
	        }
	        else
	        {
	    	    opener.document.forms[f.form_name.value].elements[f.text_element_name.value].value = f.items[f.items.selectedIndex].text;
	        }
    	}
	}
    if (f.reload.value == 1)
        opener.document.forms[f.form_name.value].submit();
    window.close();
}
--></script>
{/literal}
<form name=picker method=post>
<input type=hidden name="form_name" value="{$picker.form_name}">
<input type=hidden name="element_name" value="{$picker.element_name}">
<input type=hidden name="text_element_name" value="{$picker.text_element_name}">
<input type=hidden name="ismultiple" value="{$picker.ismultiple}">
<input type=hidden name="insert_link" value="{$picker.insert_link}">
<input type=hidden name="reload" value="{$picker.reload}">
<table width=100% height=100%>
<tr class="tblheader" height="30" align="right"><td>
{$picker.search_title}&nbsp;
<input type=text name="{$picker.search_name}" value="{$picker.search_value}" style="width:60%;"/>
<input type=submit value="Найти" style="width:100px;"/>
</td></tr>
<tr height="100%"><td width=100% valign="top">
<select name=items size=10 style="height:300;width:100%;" onDblClick="returnItem();"{if $picker.ismultiple} multiple="multiple"{/if}>
{html_options options=$picker.items}
</select>
</td></tr>
<tr class="tblheader" height="30" align="right"><td>
<input type=button value="Выбрать" onClick="returnItem();" style="width:33%;"/>
{if $picker.insert_href}<input type=button value="Добавить" onClick="window.location='{$picker.insert_href}form_name={$picker.form_name}&element_name={$picker.element_name}&text_element_name={$picker.text_element_name}&reload={$picker.reload}';" style="width:33%;"/>{/if}
<input type=button value="Закрыть" onClick="window.close();" style="width:33%;"/>
</td></tr>
</table>
</form>

{include file="footer.tpl"}