<head><link rel=stylesheet type=text/css href="style.css">
<title>{$picker.title}</title></head>
<body>
{literal}
<script language="javascript"><!--
function returnItem() {
    var f = document.picker;
    opener.document.forms[f.formName.value].elements[f.elementName.value].value = f.items[f.items.selectedIndex].value;
    if(f.reload.value == 1)
        opener.document.forms[f.formName.value].submit();
    window.close();
}
--></script>
{/literal}
<form name=picker method=post>
<input type=hidden name="formName" value="{$picker.formName}">
<input type=hidden name="elementName" value="{$picker.elementName}">
<input type=hidden name="reload" value="{$reload}">
<table width=100% height=100%>
<tr><td width=50%>{$picker.searchtitle}</td><td width=50%><input type=text name={$picker.searchname} value="{$picker.searchvalue}"></td></tr>
<tr><td colspan=2 align=right width=100%><input type=submit style="width:200px;" value="Найти"></td></tr>
<tr><td colspan=2 width=100%><select name=items size=10 style="width:100%" onDblClick="returnItem();">{html_options options=$picker.items}</select></td></tr>
<tr><td><input type=button value="выбрать" onClick="returnItem();"></td><td><input type=button value="закрыть окно" onClick="window.close();"></td></tr>
</table></form>
</body>