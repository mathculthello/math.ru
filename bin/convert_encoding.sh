#!/bin/bash

# Recursive file convertion windows-1251 --> utf-8
# Place this file in the root of your site, add execute permission and run
# Converts *.php, *.html, *.css, *.js files.
# To add file type by extension, e.g. *.cgi, add '-o -name "*.cgi"' to the find command

#find ./ -name "*.php" -o -name "*.tpl" -o -name "*.html" -o -name "*.css" -o -name "*.js"  -type f |
find ../html  -name "*.htm" -type f |
while read file
do
  echo " $file"
  mv $file $file.icv
  iconv -f WINDOWS-1251 -t UTF-8 $file.icv > $file
  rm -f $file.icv
done
