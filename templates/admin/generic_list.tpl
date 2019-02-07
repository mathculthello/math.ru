{*
$_columns
$_p - paginator
$_rows
$_href ?&
$_item_href
$_header
$_form_name
$_show_checkboxes
$_checkboxes_name
$_checkboxes_key
$_show_insert = false
$_show_delete = false
$_show_pager = false
$_order_column = ""
$_delete_column
$_delete_message
$_no_form
$_related
$_picker_href
$_target
*}
{if !$_no_form}
<form name="{$_form_name}" method="post" action="{$_href}">
{/if}

<table border="0" cellspacing="3" cellpadding="2" width="100%">
{if $_header}
<tr class="tblheader"><td>{$_header}
{if $_show_upper_insert}
{if $_related}
<input type="button" value="Добавить" onclick="popup=window.open('{$_picker_href}form_name={$_form_name}&element_name={$_related}_to_insert&reload=1&ismultiple=1','{$_related}_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
{else}
<input type="button" value="Добавить" onclick="window.location='{$_item_href}page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}'"/>
{/if}
{/if}
</td></tr>
{/if}
{if $_show_pager}
<tr><td class="pager">{include file="generic_pager.tpl" _pages_info="1" _no_form=($_form_name?"1":"0")}</td></tr>
{/if}
</table>
<hr>
<table border="0" cellspacing="3" cellpadding="2" width="100%" valign="top">

{if $_rows}

{if $_extra_header}
<tr class=tblheader1>
{foreach from=$_extra_header item=h}
<td{if $h.colspan} colspan={$h.colspan}{/if}>{$h.title}</td>
{/foreach}
</tr>
{/if}

<tr class=tblheader1>
{if $_show_checkboxes}
<td width="25">&nbsp;</td>
{/if}

{foreach from=$_columns item=c}
<td{if $c.width} width="{$c.width}"{/if}{if $c.type == 'marker' || $c.type == 'indicator'} style="cursor: hand;" onclick="window.location='{$_href}n={$_p->itemsPerPage}&page={$_p->page}&o_by={$c.name}&o={$c.order}';"{/if}>
{if $_order_column && $c.name == $_order_column}
{if $_p->orderBy == $c.name}
<a href="{$_href}n={$_p->itemsPerPage}&page={$_p->page}&o_by={$c.name}&o={$c.order}"><img src="/img/sort{$c.order}.gif" width=16 height=16 align="right" valign="bottom" border="0"/></a>
{/if}
<a href="{$_href}n={$_p->itemsPerPage}&page={$_p->page}&o_by={$c.name}&o={$c.order}">{$c.title}</a>
{else}

{if $c.ordered}

{if $_p->orderBy == $c.name &&  $c.type != 'marker' && $c.type != 'indicator'}
<a href="{$_href}n={$_p->itemsPerPage}&page={$_p->page}&o_by={$c.name}&o={$c.order}"><img src="/img/sort{$c.order}.gif" width=16 height=16 align="right" valign="bottom" border="0"/></a>
{/if}


<a href="{$_href}n={$_p->itemsPerPage}&page={$_p->page}&o_by={$c.name}&o={$c.order}">
{if $c.type == 'marker' || $c.type == 'indicator'}<img src="{$c.img}" width={$c.img_width} height={$c.img_height} title={$c.title} border=0/>
{else}
{$c.title}
{/if}
</a>

{else}
{$c.title}

{/if}

{/if}
</td>
{/foreach}
{if $_delete_column}
<td width="25">&nbsp;</td>
{/if}
</tr>
{/if}

{foreach from=$_rows item=r}
{strip}
<tr class="{if $r[$_extra.sel_row]}{$_extra.sel_class}{else}{cycle values="tbldata1,tbldata2"}{/if}" valign="top">
{if $_show_checkboxes}
<td><input type="checkbox" name="{$_checkboxes_name}[]" value="{$r[$_checkboxes_key]}">
{if $_related}
<input type="hidden" name="{$_related}[]" value="{$r[$_checkboxes_key]}"/>
{/if}
</td>
{/if}

{foreach from=$_columns item=c}
{if $_order_column && $_order_column == $c.name}
<td>
<a href="{$_href}page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}&moveend={$r.id}" title="В конец">&laquo;</a>
<a href="{$_href}page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}&movedown={$r.id}" title="Выше">&lt;</a>
<a href="{$_href}page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}&moveup={$r.id}" title="Ниже">&gt;</a>
<a href="{$_href}page={$_p->page}&o_by={$_p->orderBy}&o={$_p->order}&n={$_p->itemsPerPage}&movestart={$r.id}" title="В начало">&raquo;</a>
</td>
{else}
<td{if $c.sel_field && $r[$c.sel_field]} class={$c.sel_class}{/if}{if $c.pop_title} title="{$r[$c.pop_title]}"{/if}{if $c.width} width={$c.width}{/if}{if $c.type == 'marker'} style="cursor: hand;" title="{$c.title}" onclick="window.location='{$_href}marker={$c.name}&id={$r.id}';"{/if}>

{if $c.type == 'url'}
<a href="{$r[$c.name]}" target="_blank">
{elseif $c.type == 'email'}
<a href="mailto:{$r[$c.name]}">
{elseif $c.ref}
{if $_related}
<a href="#" onclick="popup=window.open('{$_href}&id={$r.id}&form_name={$_form_name}&element_name={$_related}_to_insert&reload=1','{$related}_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
{else}
<a href="{$_item_href}id={$r.id}"{if $_target} target={$_target}{/if}>
{/if}
{elseif $c.i_href}
<a href="{$c.i_href}id={$r[$c.i_id]}">
{/if}

{if $c.type == 'date_range'}
{$r[$c.date_start]|date_format:$c.date_format}-{$r[$c.date_end]|date_format:$c.date_format}
{elseif $c.type == 'date'}
{$r[$c.name]|date_format:$c.date_format}
{elseif $c.type == 'marker' || $c.type == 'indicator'}
{if $r[$c.name]}{if $c.img}<img src="{$c.img}" width={$c.img_width} height={$c.img_height} border=0/>{else}+{/if}{else}{if $c.img_off}<img src={$c.img_off} border="0" width="{$c.img_width}" height="{$c.img_height}">{else}&nbsp;{/if}{/if}
{elseif $c.type == 'options'}
{assign var=opt value=$c.options}
{assign var=sel value=$r[$c.name]}
{$opt[$sel]}
{elseif $c.type == 'multiple_options'}
{assign var=opt value=$c.options}
{assign var=sel value=$r[$c.name]}
{foreach from=$sel item=s name=mo}
{$opt[$s]}{if !$smarty.foreach.mo.last}<br />{/if}
{/foreach}
{elseif $c.type == 'author_list'}

{foreach from=$r.authors item=a name=authors}
<nobr><a href="/admin/lib/book_list.php?author={$a.id}" title="Все книги автора">{$a.fname|initials}{$a.sname|initials}{$a.lname}</a></nobr><br/>
{/foreach}

{elseif $c.ref}
{$r[$c.name]|default:"&lt;...&gt;"}
{else}
{$r[$c.name]}
{/if}

{if $c.type == 'url' || $c.type == 'email' || $c.ref || $c.i_href}
</a>
{/if}

</td>
{/if}
{/foreach}

{if $_delete_column}<td style='cursor: default'><a href="#" onclick="if (confirm('{$_delete_message}')) document.location='{$_delete_href}{$r.id}';" title="Удалить"><img class="button" align="absbottom" src="/i/delete.png" border=0 width=16 height=16 alt="Удалить"></a></td>{/if}

</tr>
{/strip}
{/foreach}

</table>

{if $_show_pager && $_p->PagesNumber > 1}
<table border=0 cellspacing="0" cellpadding="0" width=100%>
<tr><td class="tblheader1">{include file="generic_pager.tpl" _pages_info="0"}</td></tr>
</table>
{/if}
{if $_show_insert || $_show_checkboxes || $_show_delete}

<hr>
<table border=0 cellspacing="0" cellpadding="0" width=100%>
<tr>
{if $_show_checkboxes && $_rows}
<td align="left">
<a href="#" onclick="setCheckboxes('{$_form_name}', '{$_checkboxes_name}', true); return false;">Отметить все</a> / <a href="#" onclick="setCheckboxes('{$_form_name}', '{$_checkboxes_name}', false); return false;">Снять отметку со всех</a>
</td>
{/if}
<td align="right">
{if $_show_insert}
{if $_related}
<input type="button" value="Добавить" onclick="popup=window.open('{$_picker_href}form_name={$_form_name}&element_name={$_related}_to_insert&reload=1&ismultiple=1','{$related}_picker','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
{else}
<input type="button" value="Добавить" onclick="window.location='{if $_insert_href}{$_insert_href}{else}{$_item_href}{/if}'"/>
{/if}
{/if}
{if $_show_delete && $_rows}
<input type="submit" name="{$_delete_name|default:"delete"}" value="Удалить отмеченные"/>
{/if}
{if $_extra_buttons}
С отмеченными:
{foreach from=$_extra_buttons item=b}
<input type="{$b.type|default:"submit"}" name="{$b.name|default:"btn"}" value="{$b.value}"{if $b.confirm} onclick="return confirm('{$b.confirm}');"{/if}/>
{/foreach}
{/if}
</td>
</tr>
</table>
{/if}
{if $_related}<input type="hidden" name="{$_related}_to_insert" value=""/>{/if}
{if !$_no_form}
</form>
{/if}
