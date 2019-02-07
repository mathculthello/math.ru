<table width="100%" cellpadding="0" cellspacing="0"><tr>
<td><h1>{$term_info.title}</h1></td>
<td align="right">{if $term_info.type == 'fact'}факт{elseif $term_info.type == 'formula'}формула{elseif $term_info.type == 'term'}понятие{/if}</td>
</tr></table>
<hr size="1" noshade="noshade"/>

{if $term_info.type == 'fact' || $term_info.type == 'term'}

<p align="justify" />
{$term_info.entry|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{if $term_info.src_entry_name}<div class="src">{$term_info.src_entry_name} [{$term_info.src_entry_code}]</div>{/if}
<p align="justify" />
{if $term_info.formula}
<h2>{if $term_info.type == 'fact'}Математически верная формулировка{else}Математически верное определение{/if}</h2>
<p align="justify" />
{$term_info.formula|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{if $term_info.src_formula_name}<div class="src">{$term_info.src_formula_name} [{$term_info.src_formula_code}]</div>{/if}
{/if}
{if $term_info.comment}
<h2>Комментарий</h2>
<p align="justify" />
{$term_info.comment|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{if $term_info.src_comment_name}<div class="src">{$term_info.src_comment_name} [{$term_info.src_comment_code}]</div>{/if}
{/if}
{if $term_info.illustration}
<h2>Иллюстративный материал</h2>
<p align="justify" />
{$term_info.illustration|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{if $term_info.src_illustration_name}<div class="src">{$term_info.src_illustration_name} [{$term_info.src_illustration_code}]</div>{/if}
{/if}
{if $term_info.history}
<h2>Истроическая справка</h2>
<p align="justify" />
{$term_info.history|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{if $term_info.src_history_name}<div class="src">{$term_info.src_history_name} [{$term_info.src_history_code}]</div>{/if}
{/if}
{if $term_info.def}
<h2>{if $term_info.type == 'fact'}Формулировки из учебников{else}Определения из учебников{/if}</h2>
{foreach from=$term_info.def item=d}
<a class="alink">{$d.src_authors}. {$d.src_title}</a> [{$d.src_code}]
<div class="def">
{$d.wording|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
</div>
<div class="comment">{$d.comment|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}</div>
{/foreach}
{/if}
{if $term_info.cmp}
<h2>{if $term_info.type == 'fact'}Сравнения формулировок{else}Сравнения определений{/if}</h2>
{foreach from=$term_info.cmp item=c}
<ul class="cmpsrc">
{foreach from=$c.src item=s}
<li>{$s.author}. {$s.title}  [{$s.code}]</li>
{/foreach}
</ul>
<div class="cmp">
{$c.comp|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
</div>
{/foreach}
{/if}

{elseif $term_info.type == 'formula'}
<p align="justify" />
{$term_info.entry|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
<h2>Формула</h2>
<p align="justify" />
{$term_info.comment|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}

{if $term_info.formula}
<h2>Строгая формулировка</h2>
<p align="justify" />
{$term_info.formula|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
{/if}

{if $term_info.other_formula}
<h2>Другие виды этой формулы</h2>
{foreach from=$term_info.other_formula item=d}
<div class="def">
{$d.formula|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}
</div>
<div class="comment">{$d.comment|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}</div>
{/foreach}
{/if}

{if $term_info.def}
<h2>Встречается в учебниках</h2>
{foreach from=$term_info.def item=d}
<a class="alink">{$d.src_authors}. {$d.src_title}</a> [{$d.src_code}]
<div class="comment">{$d.comment|regex_replace:"/\n\s*\n/":"<p align=\"justify\"/>"|nl2br}</div>
{/foreach}
{/if}

{/if}

{if $term_info.references}
<h2>См. также</h2>
{foreach from=$term_info.references item=r}
<a class="alink" href="/dic/{$r.id}">{$r.title}</a><br/>
{/foreach}
{/if}