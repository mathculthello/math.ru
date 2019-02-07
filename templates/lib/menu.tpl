{*
_path
*}
<table width="180" cellpadding="0" cellspacing="0" border="0"  id="menutable">
<tr><td{if $search_mode == 'all'} class=select{/if}><a href="/lib/cat/">Полный список</a></td></tr>
<tr><td{if $_path == 'search'} class=select{/if}><a href="/lib/search">Поиск</a></td></tr>
<tr><td{if $_path == 'formats'} class=select{/if}><a href="/lib/formats">О форматах и правах</a></td></tr>
<tr><td{if $_path == 'suggest'} class=select{/if}><a href="/lib/suggest">Обратная связь</a></td></tr>
<tr><td{if $_path == 'thanks'} class=select{/if}><a href="/lib/thanks">Благодарности</a></td></tr>
</table>