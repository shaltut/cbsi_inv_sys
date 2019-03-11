TODO:

************ WEEK 1 ************
Garrett:
- Style login.php, header.php, index.php, profile.php

Diana: 
- Change database names (‘user_id’ to ‘employee_id’ etc.)


Phillip:
- Examine the form fields for any weak points (SQL injection) and patch if possible on the user.php ‘add’ button and ‘update’ button forms.



************ WEEK 2 ************

Garrett:
- Take a look at the JavaScript and JSON functions in the following pages and add comments at the top of them explaining in simple terms how they work
	- equipment.php
	- product_action.php
	- product_fetch.php
	- user.php
	- user_action.php
	- user_fetch.php
	- functions.php
	- (and any other pages w/ JS/JSON. These are just the most important at the moment)
- Also, start making the pages on the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Diana: 
- Fix the SQL queries that display the information for the user.php page so that the functions displaying totals, as well as the table below them display the right information.


Phillip:
- Examine the form fields for any weak points (SQL injection) and patch if possible on the user.php ‘add’ button and ‘update’ button forms.

Mariam:
- Find areas of the site that need improvement (such as the login display, the information displayed on each page, etc). 
- Look at other inventory systems and compare ours with theirs. (What data do they show to admins? What privelages do they give to their users? What statistics do they display that might be helpful? etc.)
	-Basically, I want to know if the data that we're displaying in our data tables on the site are going to be enough/helpful to the people using it.

Tristan: (When you get back from vacay lol)
- Look into how to set up a PHP based website with a relational database on GoDaddy and Amazon and create a pro/cons list for both (post that pro/con list here so we can all decide what the best option is)

--------------------------------------------------------------------------


ALRIGHT - here's how to do the git stuff:


"I want to update my local files with what's on github"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git pull

"I want to update a single file"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add filename.php
	> git commit -m "changelog message here"
	> git push

	*If it returns a conflict error, pull and fix conflicts, then restart this process

"I want to update all the files" (AKA push my changes to the master copy on github.)

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add -A
	> git commit -m "changelog message here"
	> git push

"I want to add a brand new file"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add newfilename.php
	> git commit -m "changelog message here"
	> git push


"I want to remove my local changes and pull the version on github"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git fetch --all
	> git reset --hard origin/master


------------------------------------------------------------------------------------------------------------------------