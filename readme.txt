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

========================================================================

******** FEEL FREE TO WORK ON ANY OF THE FOLLOWING ********
(Post in chat when you start so we dont get conflicts)

OTHER STUFF TO DO:
	--- Make equipment that requires maimtenance red (just the text, or something to notify them that is small and looks good) and equipment that will need maintenance in the next 2 weeks yellow. (in equipment.php)
		-This will require a lot of sql, php, JavaScript, and possibly jquery.
	--- Have the system email all 'master' user's email addresses when a piece of equipment is nearing it's maintenance date.
		-This will require a lot of sql, php, JavaScript, and API (if you decide to use one) knowlege.
	--- Adding animations anywhere they would look good and fit well. (easy to do in Jquery. I already added a few, and have been looking for more cool implementations)
		- jQuery
	--- Sorting by IDs doesnt work on any page, and sorting doesnt work at all on the table in check.php (return equipment)
		- Either a jquery/JS error, or a php/SQL error in the _fetch pages.
	--- Make dates on tables extracted from the DB appear in a normal format. (right now they appear as '<YEAR> - <MONTH> - <DAY>' aka -> '2019-03-08' which is confusing because that could be read as "March 8th, 2019" OR as "August 3rd, 2019" which is BAD)
		-   can be done using php function, or an sql query. Probs with javascript too, but just dont lol.
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



Errors Found That Need Fixin':
	--- Found another possible error... The "Equipment Checked Out Today" table on the index.php page displays checkouts that are over a day old as long as the user stays logged in.. When they log out and log back in, the table gets reset (realizes that the data in those tables arent from the current day.)
		- I believe this is because the table is populated only once (when the user logs in) then, as long as they log in, the table never checks for and prunes outdated rows.
		- Im gonna start looking into this, but I have a feeling its a bigger problem than it looks.
	--- Sorting by IDs doesnt work on any page, and sorting doesnt work at all on the table in check.php (return equipment)
	--- Search field not working in sites.php
	--- 'Go Back' button on sites.php and user.php not working
	--- Graphs shown on Monday not showing in stats anymore
	--- Navbar gets cut off on the right in InternetExplorer browser≥.

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