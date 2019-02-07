<!doctype html public "-//w3c//dtd html 4.0 transitional//en">
<html>
<head>
<title>Math.ru</title>
<meta http-equiv="content-type" content="text/html; charset=windows-1251"/>
<meta name="keywords" content="math.ru"/>
<meta name="description" content="math.ru"/>
<link rel="stylesheet" href="/style_nn.css" type="text/css"/>
</head>
<body>

<table width="100%">
<tr class="tblheader1"><td>Код</td><td>Название</td></tr>
{foreach from=$courses item=c key=k name=course}
<tr class="{cycle values="tbldata1,tbldata2"}"><td>{$k}</td><td><a href="javascript:opener.document.register.course.selectedIndex={$smarty.foreach.course.iteration-1};window.close();">{$c}</a></td></tr>
{/foreach}
</table>

</body>
</html>