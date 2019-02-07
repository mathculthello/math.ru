{include file="header.tpl"}

<table><tr>
<td id=menucol valign=top  height="85%" width="181">
{foreach from=$_menu item=g}
{if $g.title}
<div class=tit4>{$g.title}</div>
{/if}
<table width="180" cellpadding=0 cellspacing=0 border=0  id=menu>
{foreach from=$g.items item=m}
{if $m.path == $_path}
<tr><td class=sel><img src="/i/m_u1.gif" width="180" height="4"></td></tr>
<tr id="txt"><td class=sel>{$m.title}</td></tr>
<tr><td class=sel><img src="/i/m_d1.gif" width="180" height="4"></td></tr>
{else}
<tr><td><img src="/i/m_u1.gif" width="180" height="4"></td></tr>
<tr id="txt"><td><a href="{$m.path}" target="{$m.target|default:"main"}">{$m.title}</a></td></tr>
<tr><td><img src="/i/m_d1.gif" width="180" height="4"></td></tr>
{/if}
{/foreach}
</table>
{/foreach}
</td></tr></table>
<br/>

{*
<a target="main" href="news/">Новости</a><br/><br/>
<b>Библиотека</b><br>
<a target="main" href="lib/book_list.php?all=1">Книги</a><br>
<a target="main" href="history/person_list.php?all=1">Авторы</a><br>
<a target="main" href="lib/series_list.php">Серии книг</a><br>
<a target="main" href="lib/rubr_list.php">Рубрикатор</a><br>
<a target="main" href="lib/catalog_list.php">ТК</a><br>
<a target="main" href="lib/suggest_list.php">"Обратная связь"</a><br>
<br>
<b>Медиатека</b><br>
<a target="main" href="media/lecture_list.php">Видео лекции</a><br>
<br>
<b>История математики</b><br>
<a target="main" href="history/person_list.php?mode=person">Люди</a><br>
<a target="main" href="history/story_list.php">Сюжеты</a><br><br>
<a target="main" href="history/tree.php">Древо Лузина</a><br>
<a target="main" href="history/tree_new.php">Добавления</a><br>
<a target="main" href="history/tree_edit.php">Изменения</a><br>
<br>
<b>Учительская</b><br>
<a target="main" href="teacher/doc_list.php">Документы</a><br>
<a target="main" href="teacher/cat_list.php">Разделы</a><br>
<br>
<b>База задач</b><br>
<a target="main" href="section_tree.php">Разделы</a><br>
<a target="main" href="subject_tree.php">Тематический каталог</a><br>
<a target="main" href="pb_message_list.php">Форум</a><br>
<br>
<br>
<b>TeX</b><br>
<a target="main" href="tex2png/tex2png.php">TeX->png</a><br>
<a target="main" href="tex2mathml.php">TeX->MathML</a><br>
*}
{include file="footer.tpl"}
