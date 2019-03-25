fTODO:

************ WEEK 1 ************
Garrett:
- Style login.php, header.php, index.php, profile.php



************ WEEK 2 ************

Garrett:
- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Diana: 
- Structure the user_details table so it matches the EMPLOYEES table in the DB_PLAN.txt file.
- See if you can get those functions to look right as well on the users.php page


Phillip:
- Create a new .php page called 'search.php' using the code from equipment.php. 
	-This page will only be seen by standard users. so try to use those php functions that only display the page to users that are of type 'user' and limit their view of the data to only include basic info...
	*** You're probs like "wot m8?", so private message me and ill explain it in more detail... lol

Mariam:
- Find areas of the site that need improvement (such as the login display, the information displayed on each page, etc). 
- Look at other inventory systems and compare ours with theirs. (What data do they show to admins? What privelages do they give to their users? What statistics do they display that might be helpful? etc.)
	-Basically, I want to know if the data that we're displaying in our data tables on the site are going to be enough/helpful to the people using it.

Tristan: (When you get back from vacay lol)
- Look into how to set up a PHP based website with a relational database on GoDaddy and Amazon and create a pro/cons list for both (post that pro/con list here so we can all decide what the best option is)
- Look at the code for the site and really familliarize yourself with it. Mess with it to try and understand what everything does and how the database works and all that.

************ WEEK 3 ************

Garrett:
- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).
- Theres some CSS in the login.php page that I added there to center the image. Try to move that to the CSS pages. I didnt want to mess with anything in there since you probs know it better than I do. 	
	- Also feel free to change it or mess with the image in there or whatever you want as long as it looks good in mobile and desktop.(I didnt spend much time on it so if theres a cleaner way to do it or a better looking way to do it, go for it!)

Diana: 
- Keep working on anything that needs to be done in the users pages.
- Work on user views. We've been so concentrated on master accounts that I feel like user accounts arent all there. Change whatever you think you need to change and make the standard user accounts user-friendly and whatnot. 


Phillip:
- Take a look at the error codes displayed by the system. Make sure they dont display any data about the database (like table names, column names, etc.)... We Learned in IT-369 that hackers will purposefully break websites to get the default error codes (or pages) returned by the system which usually contain vital info about the database. 
	- Ive seen this a few times already on the site... like "Error:234215jhh:h on page /Applications/XAMPP/htdocs/cbsi_inv_sys/user_fetch.php : Invalid data marker on user_details table, user_id cannot be Null"
	.....This tells the user both the name of the table in the database, as well as the column name of the primary key for that table... Thats bad...
- Once you find some of these errors, create default error pages. So make the system navigate to an error page that you've created instead of showing them the default system error code...
	- I highly suggest you do all this on a copy of the project (since youll pretty much just be breaking the project). You dont want to accidentally push those errors, and plus, youll be working on pages that the rest of us are working on, so youll have conflicts as well if you use the main repo.
***Again, ive given you a weird ass assignment, so if you have questions, or want to know of ways to break the database, just ask me and ill see if i can help!

Mariam:
- Img on login.php (which youve done already)
- Use a duplicate of the system to help Philip find error codes (read above). Basically just help him break the site and find the error codes that are returned. This is a big job since theres plenty of areas that can be broken in the site.	
	-Maybe also look up how to create custom error codes for a website for phillip and send him any info you can find on that.

Tristan: (When you get back from vacay lol)
- Nice work on the hosting info! Ill have to ask them about the GoDaddy login info and how to use it. Looks like Amazon would be the best option, but could potentially cost more if they already have server space that theyre paying for.. Ill have to figure that out...
- Take a look at the functions in the functions.php page and the data they display in the user.php, equipment.php, and sites.php pages. 
	-Make them display useful data by creating functions and using them in those pages.
	**I think the user.php page is fine right now, but the other two need work.

	Been messing with them and functions and I'm reluctant to make any major styling changes to it as I feel then it wouldn't fit with the rest of the page. We can discuss on that though. 
	Added a column to stats and changed the names so that we can monitor sites in DC or NOVA, began function and continued implementation dependent on how we can monitor that and if it would be useful, besides that just active and inactive are the columns. 
	For equipment changed the function for currently checked out and began working on a needs maintenance function, need to discuss how it will actually work to provide useful info not just what is marked as will need maintenance at some point.

************ WEEK 4 ************

Garrett:

Diana: 
	- Try to fix github


Phillip:
	- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Mariam:
	- Find where the Search (and input for search), Show Entries (and the input for show entries), and the 'showing' txt is added to tables by default. Then figure out how to make that extra stuff optional.

Tristan:
	- fix the error in the check-out function (sites_options($connect)) where if you dont enter a 'site' option, it still lets you check out that piece of equipment, and returns 0 as the site_id.


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