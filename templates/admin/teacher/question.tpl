{include file="header.tpl"}
<table width=100%>
<tr class="tblheader"><td colspan="2">Ответ на вопрос</td></tr>
</table>
{include file="message.tpl"}
<br/>

<form name=article enctype="multipart/form-data" action="/admin/teacher/question.php" method=post>

<table width=100%>
<colgroup width="300"><colgroup width="*">
<tr><td class=tblheader1 valign=top>Название вопроса</td><td><input type=text size=80 name=title value="{$title}"></td></tr>
<tr><td class=tblheader1 valign=top>Автор</td><td>
<a href="javascript:window.open('/admin/auth/user_view.php?id={$user}','user','width=620,height=420,left=' + ((screen.width-620)/2) + ',top=' + ((screen.height-420)/2) + ',scrollbars=yes,resizable'); popup.focus();">{$user_fullname}</a>
</td></tr>
<tr><td class=tblheader1 valign=top>Вопрос</td><td><textarea name=question cols=80 rows=20>{$question}</textarea></td></tr>
<tr><td align=right class=tblheader1>Тема вопроса</td><td>
<select name="forum">{html_options options=$forum_options selected=$forum}</select>
</td></tr>
<tr><td class=tblheader1 valign=top>Ответ</td><td><textarea name="answer" cols=80 rows=20>{$answer}</textarea></td></tr>
{if $file}
<tr><td class=tblheader1 valign=top>Файл с развернутым ответом</td><td><a href="/teacher/metod/files/{$file}"><input type="hidden" name="size" value="{$size}"><input type="hidden" name="file" value="{$file}">{$file}</a></td></tr>
<tr><td class=tblheader1 valign=top>Удалить файл</td><td><input type="checkbox" name="delete_file"/></td></tr>
{/if}
<tr>
<td class=tblheader1 valign=top>Загрузить{if $file} новый{/if} файл с ответом</td>
<td><input type=file name="upload_file"/></td>
</tr>
<tr><td class=tblheader1 valign=top>Ответил</td><td><input type=text size=80 name=answered_name value="{$answered_name}"></td></tr>
<tr><td class=tblheader1>Опубликовать на форуме</td><td class=tbldata2 valign="top">
<input type="checkbox" name="publish" value="1"{if $publish} checked="checked"{/if}>
</td></tr>
</table>

<hr>
<div align=right>
<input type=submit name=save value="Отправить ответ">
{if $id}<input type=submit onclick="return confirm('Удалить вопрос?');" name=delete value="Удалить"/>{/if}
<input type="button" onclick="window.location='/admin/teacher/question_list.php'" value="К списку вопросов"/>
</div>

<input type=hidden name=thread value={$thread}>
<input type=hidden name=post value={$post}>
<input type=hidden name=post_answer value={$post_answer}>
<input type=hidden name=show_author value={$show_author}>
<input type=hidden name=user value={$user}>
<input type=hidden name=answered value={$answered}>
<input type=hidden name=id value={$id}>
<input type=hidden name=q value=1>
</form>
{include file="footer.tpl"}