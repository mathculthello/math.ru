{*
$_show_parent
$_show_checkboxes
$_href

{if !$_href}
{assign var="_href" value="/admin/lib/ad_list.php"}
{/if}
<table border="0" cellspacing="3" cellpadding="2" width="100%">
<tr class="tblheader1">
{if $_show_checkboxes}<td> </td>{/if}{if $_show_parent}<td>Книга</td>{/if}<td>Дата</td><td>Страница</td><td>Текст</td>
</tr>
{foreach from=$ad_list item=item}
{strip}
<tr class="{cycle values="tbldata1,tbldata2"}">
{if $_show_checkboxes}<td><input type="checkbox" name="lib_ad_list[{$item.id}]" value="{$item.id}"/></td>{/if}
{if $_show_parent}<td><a href="/admin/lib/book.php?id={$item.book_id}">{$item.book_title}</a></td>{/if}
<input type=hidden name="ad[]" value="{$item.id}"/>
<td>{$page}</td>
<td width=200>{$item.ts|date_format:"%d.%m.%Y"}</td>
<td><a href="#" onclick="popup=window.open('/admin/lib/ad.php?id={$item.id}&book_id={$id}&form_name=book&reload=1&short=1','ad_picker','width=800,height=420,left=' + ((screen.width-800)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">{$item.txt|truncate:80}</a></td>
</tr>
{/strip}
{/foreach}
</table>

<input type="hidden" name="ad_to_insert" value=""/>
<hr/>
<input type="button" name="lib_ad_list_insert" value="Добавить отрывок" onclick="popup=window.open('/admin/lib/ad.php?book_id={$id}&form_name=book&element_name=ad_to_insert&reload=1&short=1','ad_picker','width=800,height=420,left=' + ((screen.width-800)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus(); return false;">
*}

{include file="generic_list.tpl" _related="ad" _show_delete="1" _delete_name="ad_delete" _no_form="1" _form_name="book" _show_checkboxes="1" _checkboxes_name="ad_to_delete" _checkboxes_key="id" _show_insert="1" _rows=$ad_list _columns=$ad_columns _item_href="/admin/lib/ad.php?book_id=$id&short=1&form_name=book&element_name=ad_to_insert&" _picker_href="/admin/lib/ad.php?book_id=$id&short=1&form_name=book&element_name=ad_to_insert&" _target="_new"}
