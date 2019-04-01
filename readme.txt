TODO:

************ WEEK 4 ************

Garrett: 
	- Display tables (DataTables) as 'cards' (or something similar) for mobile compatibility.

Diana: 
	- make the 'view' button on the maintain.php page for each item requireing maintenance display only info about maintenace, not the user who entered it in, etc.--REMOVED THE USER INFO ON THE VIEW AND THE BASE PRICE.


Phillip:
	- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Mariam:
	- Find where the Search (and input for search), Show Entries (and the input for show entries), and the 'showing' txt is added to tables by default. Then figure out how to make that extra stuff optional.

Tristan:
	- fix the error in the check-out function (sites_options($connect)) where if you dont enter a 'site' option, it still lets you check out that piece of equipment, and returns 0 as the site_id.

OTHER STUFF TO DO:
	--- Make equipment that requires maimtenance red and equipment that will need maintenance in the next 2 weeks yellow.
	--- Have the system email all 'master' user's email addresses when a piece of equipment is nearing it's maintenance date.
	--- Adding color coded Glyphicons could make the site more unique and user friendly! Check out Bootstrap Glyphicons and try to find ways to implement them!
	--- Found another possible error... The "Equipment Checked Out Today" table on the index.php page displays checkouts that are over a day old as long as the user stays logged in.. When they log out and log back in, the table gets reset (realizes that the data in those tables arent from the current day.)
		--- I believe this is because the table is populated only once (when the user logs in) then, as long as they log in, the table never checks for and prunes outdated rows.
		---Im gonna start looking into this, but I have a feeling its a bigger problem than it looks.
	--- Add graphs to the stats page. Maybe based on checkouts? Or other visual representations of data.
	--- Animations (easy to do in Jquery. I already added a few, and have been looking for more cool implementations)
	--- search.php should show id, prod_name, view button, availability (glyph).
	--- LETS START DEBUGGING. (see "shit to test").

	SHIT TO TEST:
	--- 10+, 25+, 50+, and 100+ users. Add dummy test user accounts 10 at a time and test how the tables/database reacts to the influx of data.
	--- User accounts vs Master accounts. DONT FORGET TO TEST AS AN ADMIN AND AS A REGULAR USER!
	--- FORMS:
		-Input fields (specifically inputting incorrect input, and viewing how the system handles it)
		-The ability to NOT enter values for values that arent required (make sure all 'optional' fields are actually optional)
	--- Different Browser:
		- Google Chrome, Safari, Opera, IE, FireFox, etc.
	--- Moblie compatibility. Download emulators (or just use XCode if you have that downloaded)
	--- SYSTEM DATES: Almost the entire check system, as well as the maintenance system works based off of system dates... We should make sure the dates are correctly entered, and properly interpreted by the system. (more on this talk to me)

	SOLVED:
	--- (SOLVED ON 3/31 BY DIANA B.)Change the 'Entered By' column on the equipment.php page to display the user's name (user_name) instead of the user's ID number.
	--- (SOLVED ON 3/31 BY DIANA B.)When you navigate to the site.php page, and open a modal, whatever modal you open, the heading for that modal gets stuck on that headding. 
		-- (SOLVED ON 3/31 BY DIANA B.) So if you click the "add" button, the modal will open up with a heading that says "Add Item" (it should say "Add Site" but thats another problem...) then you close that modal, and click the "View" button for a site on the table, the view modal opens, but it keeps the "Add Item" heading.
		-- (SOLVED ON 3/31 BY DIANA B.) This same error can be found on Equipment.php!


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