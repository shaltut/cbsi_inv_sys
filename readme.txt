TODO:

************ WEEK 4 ************

Garrett: 
	- Display tables (DataTables) as 'cards' (or something similar) for mobile compatibility.

Diana: 
	- make the 'view' button on the maintain.php page for each item requireing maintenance display only info about maintenace, not the user who entered it in, etc.


Phillip:
	- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Mariam:
	- Find where the Search (and input for search), Show Entries (and the input for show entries), and the 'showing' txt is added to tables by default. Then figure out how to make that extra stuff optional.

Tristan:
	- fix the error in the check-out function (sites_options($connect)) where if you dont enter a 'site' option, it still lets you check out that piece of equipment, and returns 0 as the site_id.

OTHER STUFF TO DO:
	--- Make equipment that requires maimtenance red and equipment that will need maintenance in the next 2 weeks yellow.
	--- Have the system email all 'master' user's email addresses when a piece of equipment is nearing it's maintenance date.
	--- Fix the maintenance function:
		- Create another column in the equipment table that stores the date that the piece of equipment will need to be maintained (by using the current function, creating a new date (in the future using last_maintained + maintain_every) and storing it in that column upon creation (or modification)
	--- Change the 'Entered By' column on the equipment.php page to display the user's name (user_name) instead of the user's ID number.
	--- When you navigate to the site.php page, and open a modal, whatever modal you open, the heading for that modal gets stuck on that headding. 
		-- So if you click the "add" button, the modal will open up with a heading that says "Add Item" (it should say "Add Site" but thats another problem...) then you close that modal, and click the "View" button for a site on the table, the view modal opens, but it keeps the "Add Item" heading.
		-- This same error can be found on Equipment.php!

========================================================================
Hosting AWS VS GoDaddy

 AWS Option: All running in Amazon Virtual Private Cloud 
 Apache Web Server with PHP + MySQL DB running on an EC2 instance of Amazon Linux... MySQL database as Amazon RDS MySQL DB

 Pros: Very well documented with clear tutorials
 Built in security groups and easy configuration

 Cons:

 Price: Will calculate ranges using AWS CloudWatch

 Initial implementation steps
 	Create RDS DB instance (Will look into and show to our DB pros)

 	Create Amazonn Linux EC2 instance and install Apache

GoDaddy Option: Linux Hosting and MySQL over cPanel

 Pros: Seems to be a common feature of the site although documentation presented on site is very vague
 They're already using goDaddy

 Cons: Vague documentation, not as customizable as AWS, No free testing period, difficult to gauge the upfront cost
 Prices are set upfront and not based on usage

 Price: Likely Deluxe tier at 4.99/month. Need to see their current planm

 Initial implementation steps

 Obtain current plan from CBSI
 Research the process for how it is hosted and connected with the DB
 Upload files with FTP
 connect DB
 	

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