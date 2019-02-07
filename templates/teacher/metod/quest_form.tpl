<form method=post action=/teacher/metod/q.php name=q>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt><table width=100% cellpadding=5><colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Название вопроса</td><td class=tbldata2>
<input type="text" name="title" value="{$title|escape}" size="30">
</td></tr>
<tr><td align=right class=tbldata1 valign="top">
Вопрос</td><td valign="top">
<textarea name="question" cols="60" rows="10">{$question|escape}</textarea>
</td></tr>
<tr><td align=right class=tbldata1>Тема вопроса</td><td class=tbldata2>
<select name="forum">{html_options options=$forum_options selected=$forum}</select>
</td></tr>
<tr><td align=right class=tbldata1>Публиковать на форуме указание на автора вопроса</td><td class=tbldata2 valign="top">
<select name="show_author">{html_options options=$show_author_options selected=$show_author}</select>
</td></tr>
</table></td></tr>

<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="10"></td></tr>

<tr><td align=right><input type=submit name=q value="Отправить вопрос" class="button"></td></tr>
</table>
</form>
