    <!-- Блок новостей -->
    <div class="tit1">&nbsp;Новости</div>
{foreach from=$news_titles item=n}
    <p><strong>{$n.date|date_format:"%d.%m.%Y"}</strong><br/>
{$n.title}
{if $n.text}
<div align="right"><a href="/news/{$n.id}">Подробнее &raquo;</a></div>
{/if}
</p>
{/foreach}
    <div><a href="">все новости »</a></div><img src="/i/p.gif" width="1" height="10"/><br/>
    <!-- конец новостей -->
