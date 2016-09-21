<?php include('includes/header.php');?>
Content goes here<br>
<?php
/*
If you repeat content on more than one page you can use an include file (also known as a server side include or SSI).

When more than one page of your site needs to use the same code (for example in the header or footer of a page), you can put that code in a separate php file and then include it in every page that needs to use it.

Using include files means that if you need to update that part of the page you only need to udpate the one include file and the changes will be made across the entire site.

To include the file you use one of two commands: INCLUDE or REQUIRE followed by the file you want to include (commonly this will be a relative URL).

The difference between the two is what the PHP processor does if the include file cannot be found.
If the INCLUDE directive is used, but the file cannot be found, then the processor will move onto the next line.
If the REQUIRE directive is used, then the PHP processor will stop if it cannot find the file.

INCLUDE '../to/file.php' ;
REQUIRE '../to/file.php'

The include file inherits the scope that it would based on where the line is included




In this example, you can see how the header and main navigation for the site has been moved into three include files:

header.php
nav.php
search-form.php

Note how the nav.php collects the current filename from the _____ superglobal variable. 
This is used in conditional statements that surround each link to indicate the current page i the navigation.
The current page has no link around it and uses a different CSS class to control the presentation.

There is another variation: include_once 'filename'
For when a file can only be included once within the page (whereas a simple search / subscribe form could be used in the header and footer of each page).
*/

?>
<?php include('includes/footer.php');?>