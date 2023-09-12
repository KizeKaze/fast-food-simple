To start any issue

git checkout master

git pull

git checkout -b (New branch name here)

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

what to do when youre waiting for a merge

push work out into git hub anyways

repeat "To start any issue"

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

coding_style


Variables / properties should be declared using snake_case
Classes should be declared using PascalCase
Class methods should be declared using camelCase
Constants should be declared using SCREAMING_SNAKE_CASE
if / elseif / while / for / foreach etc. should have their { on the same line
Functions / Classes should have their { on the next line
We will be using single quotes for anything php-related, and double quotes for anything HTML related

~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

unit testing for Killians
to run a test use vendor/bin/phpunit tests/examplefile.php
if you want to use DD to help debug
vendor/bin/phpunit tests/UserTest.php --bootstrap ./vendor/autoload.php

 replace inserts with insertOrderComplete to test the function in the CART CLASS, this is just hand testing.
 I should only write queries in a (integration test || unit test) to validate database contents.




