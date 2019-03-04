ALRIGHT - here's how to do the git stuff:

------------------------------------------------------------------------------------------------------------------------

"I want to update my local files with what's on github"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git pull

"I want to update a single file"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add filename.php
	> git commit -m "changelog message here"
	> git push

	*If it returns a conflict error, pull and fix conflicts, then restart this process

"I want to update all the files"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add -A
	> git commit -m "changelog message here"
	> git push

"I want to add a brand new file"

	> cd C:/xampp/htdocs/cbsi_inv_sys
	> git add newfilename.php
	> git commit -m "changelog message here"
	> git push







TODO:

Garrett:
- Style login.php, index.php, profile.php

Diana: 
- Change database names (‘use_id’ to ‘employee_id’ etc.)

Tristan:
- See if you can delete any traces of the ‘brand.php’ page and links to it from the site

Mariam:
- See if you can delete any traces of the ‘orders.php’ page and links to it from the site

Phillip:
- Examine the form fields for any weak points (SQL injection) and patch if possible on the user.php ‘add’ button and ‘update’ button forms.


