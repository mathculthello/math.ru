<script language=javascript>
var src_list = new Array();
{foreach from=$src_list item=s key=k}
src_list[{$k}] = {literal}{{/literal}id:'{$s.id}', code: '{$s.code}', type: '{$s.type}'{literal}}{/literal};
{/foreach}

{literal}
function update_src_list() {
	var s = document.src["src[]"].options;
	var sr = document.src;

	var show_all = false;
	if (sr["src_type[textbook]"].checked || sr["src_type[book]"].checked || sr["src_type[aid]"].checked || sr["src_type[person]"].checked || sr["src_type[inet]"].checked || sr["src_type[other]"].checked) {
		show_all = false;
	} else {
		show_all = true;
	}
	
	s.length = 0;
	var j = 0;
	for (i = 0; i < src_list.length; i++) {
		if (show_all || document.src["src_type[" + src_list[i].type + "]"].checked) {
			s[j] = new Option(src_list[i].id, src_list[i].id);
			s[j].text = src_list[i].code;
			j++;
		}
	}
}
{/literal}
</script>

<div class="tit3">&nbsp;Рубрикатор</div>
<div style="text-align:left">
{foreach from=$top_rubr item=r}
<a href="/dic/rubr/{$r.id}" class="alink">{$r.name}</a><br/>
{/foreach}
</div>
<br/>

{include file="lib/alpha.tpl" _href="?letter=" _l=$letter _rus="1"}
{if $letter}
<input type="button" onclick="document.location='?letter=';" value="отменить"/>
{/if} 
<div class=tit1>&nbsp;Классы</div>
<form name="grade" method="post">
<br/>
&nbsp;с <select name="grade_from">{html_options options=$grade_options selected=$grade_from}</select> по <select name="grade_to">{html_options options=$grade_options selected=$grade_to}</select>
<input type="submit" value="выбрать">
<br/>
<br/>
</form>

<div class=tit4>&nbsp;Типы статей</div>
<form name="type" method="post">
<div style="text-align:left">
{foreach from=$type_options item=s key=k}
<input type="checkbox" name="type[{$k}]" value="{$k}" {if $type[$k]}checked="checked" {/if}/><label>{$s}</label><br/>
{/foreach}
</div>
<input type="submit" name="select_type" value="выбрать">
<br/>
<br/>
</form>

<div class=tit2>&nbsp;Источники</div>
<form name="src" method="post">
<div style="text-align:left">
{foreach from=$src_type_options item=s key=k}
<input type="checkbox" name="src_type[{$k}]" value="{$k}" {if $src_type[$k]}checked="checked" {/if} onclick="update_src_list();" /><label>{$s}</label><br/>
{/foreach}
</div>
<select name="src[]" multiple="multiple" style="width:180px;" size="10">
{html_options options=$src_options selected=$src}
</select>
<br/>
<input type="submit" name="cancel_src" value="отменить" style="width:50%;" /><input type="submit" name="select_src" value="выбрать" style="width:50%;" />
</form>