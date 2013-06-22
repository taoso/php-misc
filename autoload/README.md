PHP class autoloader by namespace
========

Class Hello is defined with name space "a\b" in file a\b\Hello.php.
autoloader.php will convert the name space "a\b" to directory "a/b"
and try to include the file of path "a/b/Hello.php".
