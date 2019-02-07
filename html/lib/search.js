function search_books(authors, keywords, year)
{
	var result = new Array();
	var i;
	authors = trim(authors);
	keywords = trim(keywords);
	year = trim(year);
	if (authors != "")
	{
		author_list = split(authors);
		for (i in author_list)
		{
			if (author_index[author_list[i]])
			{
				result = count(result, author_index[author_list[i]]);
			}
		}
	}
	if (keywords != "")
	{
		key_list = split(keywords);
		for (i in key_list)
		{
			k = base(key_list[i]);
			if (key_index[k])
			{
				result = count(result, key_index[k]);
			}
		}
	}
	if (year != "")
	{
		if (year_index[year])
		{
			result = count(result, year_index[year]);
		}
	}
	result.sort(cmp);
	return result;
}

function cmp(a, b)
{
	return (b.rel-a.rel);
}

function find (arr, id)
{
	for (var i = 0; i < arr.length; i++)
	{
		if (arr[i].id == id)
		{
			return i;
		}
	}
	
	return arr.length;
}

function trim(str)
{
	while (str.substring(0,1) == ' ')
	{
		str = str.substring(1, str.length);
	}
	while (str.substring(str.length-1, str.length) == ' ')
	{
		str = str.substring(0, str.length-1);
	}
	return str;
}

function split (str)
{
	var s;
	var res = new Array();
	var arr = str.split(" ");
	var c = 0;
	for (var i = 0; i < arr.length; i++)
	{
		s = trim(arr[i]);
		if (s != "")
		{
			res[c] = s;
			c++;
		}
	}
	return res;
}

function count(res, idx)
{
	var i;
	for (id in idx)
	{
		i = find(res, idx[id]);
		if (i < res.length)
		{
			res[i].rel++;
		}
		else
		{
			res[i] = new Array();
			res[i].id = idx[id];
			res[i].rel = 1;
		}
	}
	
	return res;
}

function base(key)
{
	return key;
}