{include file="header.tpl"}
<tr>
<td id=content valign=top align=center colspan="3"><div>
{include file="generic/message.tpl"}

<form method=post action=/auth/reg-mos1.php name=register>
<table width=100% cellpadding=0 cellspacing=0>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td id=cnt>

<table width=100% cellpadding=5>
<colgroup width=350><colgroup width="*">
<tr><td align=right class=tbldata1>Логин <BR>(<I>например, sch1354</I>):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2><input type=text size=30 name="newlogin" value="{$newlogin}"></td></tr>
<tr><td align=right class=tbldata1>Email:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><BR><div class=small><I>Email будет использован для восстановления забытого пароля.</I></div></td><td>
<input type=text size=30 name=email value="{$email}"></td></tr>
<tr><td align=right class=tbldata1>Пароль<BR>(<I>Пароль даст возможность работать на сервере math.ru</I>):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=password size=30 name=password></td></tr>
<tr><td align=right class=tbldata1>Подтверждение пароля:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a><div class=small align=right>Введите еще раз новый пароль.</div></td><td>
<input type=password size=30 name=password2></td></tr>

<tr><td align=right class=tbldata1>Тип образовательного учреждения:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td class=tbldata2>
<select name="school_type">
<option value="school" {if $school_type == "school" || !$school_type} selected=selected{/if}>Школа</option>
<option value="liceum"{if $school_type == "liceum"} selected=selected{/if}>Лицей</option>
<option value="high"{if $school_type == "high"} selected=selected{/if}>Гимназия</option>
<option value="uvk"{if $school_type == "uvk"} selected=selected{/if}>УВК</option>
</select>
</td></tr>

<tr><td align=right class=tbldata1>Номер образовательного учреждения <BR> (<I>четырехзначное число 0789, 1303, 1547.<BR> Если номера нет - 0000</I>):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=5 name=school_num value="{$school_num}"></td></tr>

<tr><td align=right class=tbldata1>Полное название образовательного учреждения:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=50 name=school value="{$school}"></td></tr>

<tr><td align=right class=tbldata1>Контактное лицо (Фамилия, имя, отчество):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=50 name=contact_fio value="{$contact_fio}"></td></tr>

<tr><td align=right class=tbldata1>Контактное лицо - должность<BR> (<I>если учитель, то какого предмета</I>):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=50 name=contact_pos value="{$contact_pos}"></td></tr>

<tr><td align=right class=tbldata1>Телефон <BR>(<I> (495)-123-4567 или (926)-456-0987</I> ):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=50 name=contact_phone value="{$contact_phone}"></td></tr>

<tr><td align=right class=tbldata1>Индекс школы (123456):<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=7 name=contact_zip value="{$contact_zip}"></td></tr>

<tr><td align=right class=tbldata1>Полный адрес школы:<a title="Обязательно для заполнения" href="#" style="color:red; font-size:20px;">*</a></td><td>
<input type=text size=50 name=contact_address value="{$contact_address}"></td></tr>

<tr><td align=right class=tbldata1>Специализация школы:</td><td>
<input type=text size=50 name=school_profile value="{$school_profile}"></td></tr>

<tr><td align=right class=tbldata1>Сайт школы:</td><td>
<input type=text size=50 name=school_site value="{$school_site}"></td></tr>

<tr><td align=right class=tbldata1>Доп. информация:</td><td>
<textarea name="extra_info">{$extra_info|escape}</textarea>
</td></tr>

</table>

</td></tr>
<tr><td id=razd width=1 height=1><img src="/i/p.gif" width="1" height="1"></td></tr>
<tr><td width=1 height=10><img src="/i/p.gif" width="1" height="01"></td></tr>
<tr><td align=right><input type=submit name=reg value="Отправить"></td>
</table>

</form>

</div></td>
</tr>
{include file="footer.tpl"}