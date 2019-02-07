<div class="tit2">Формат</div>
<p><nobr>
{if $format == 'mathml'}<b>MathML</b>{else}<a href="?id={$id}&amp;format=mathml&amp;n={$_p->itemsPerPage}&amp;page={$_p->page}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}">MathML</a>{/if}|{if $format == 'png'}<b>HTML+png</b>{else}<a href="?id={$id}&amp;format=png&amp;n={$_p->itemsPerPage}&amp;page={$_p->page}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}">HTML+png</a>{/if}|{if $format == 'tex'}<b>TeX</b>{else}<a href="?id={$id}&amp;format=tex&amp;n={$_p->itemsPerPage}&amp;page={$_p->page}&amp;o={$_p->order}&amp;o_by={$_p->orderBy}">TeX</a>{/if}
</nobr>
</p>
<img src="/i/p.gif" width="1" height="20"/><br/>