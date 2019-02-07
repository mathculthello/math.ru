<div id=catalog>
<h1>Рубрикатор</h1>
{foreach from=$rubricator item=r}
<a {if $r.id == $rubr}class=select{else}href="/lib/rubr/{$r.path}"{/if}>{$r.name}</a><br/>
{/foreach}
</div>