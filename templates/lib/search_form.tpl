{literal}
<script language="javascript">
function clearForm() {
    document.lib_search.search_author.value = '';
    document.lib_search.search_keyword.value = '';
    document.lib_search.search_fromyear.value = '';    
    document.lib_search.search_toyear.value = '';    
    document.lib_search.type.selectedIndex = 0;
    document.lib_search.author_options.selectedIndex = 0;
    document.lib_search.keyword_options.selectedIndex = 0;
    document.lib_search.search_intitle.checked = 1;
    document.lib_search.search_incontents.checked = 0;
    document.lib_search.search_inanno.checked = 0;
}
</script>
{/literal}
<br/>
<form method=post action=/lib/cat/search name=lib_search><table width=100% cellpadding=5>
<tr class="tblheader"><td colspan="4">Поиск</td></tr>
<tr>
<td class=tblheader1 align=right width=180>Ключевые слова</td><td><input type=text size=30 name=search_keyword value="{$search_keyword}"></td>
<td class=tblheader1 align=right>искать</td><td>
<select name=search_in>
<option value='title'{if $search_in == 'title'} selected="selected"{/if}>в названии</option>
<option value='all'{if $search_in == 'all'} selected="selected"{/if}>в названии,аннотации,содержании</option>
<option value='fulltext'{if $search_in == 'fulltext'} selected="selected"{/if}>по всему тексту</option>
</select></td>
</tr>
<tr>
<td class=tblheader1 align=right width=180>Автор(ы)</td><td width=200><input type=text size=30 name=search_author value="{$search_author}"></td>
<td class=tblheader1 align=right>Год</td><td>с <input type=text size=5 name=search_fromyear value="{$search_fromyear}"> по <input type=text size=5 name=search_toyear value="{$search_toyear}"></td>
</tr>
<tr>
<td colspan=2>{if $search_id}<input type="checkbox" name="search_again" value="{$search_id}"> Искать в найденном{/if}</td>
<td colspan=2><input type=submit value="Поиск" style="width:100%"></td>
</tr>
</table><input type=hidden name=search value=1>
</form>
