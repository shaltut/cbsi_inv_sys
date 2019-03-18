TODO:

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

************ WEEK 3 ************

Garrett:
- Make the site mobile friendly by adding responsive CSS (so that it looks the same on desktop as it does now, but all fits properly on mobile devices and is easier to use).

Diana: 
- Start working on the search.php page that philip created. Make it so the users cant delete, update, or view any data they shouldnt have access to. 


Phillip:
- 

Mariam:
- 

Tristan: (When you get back from vacay lol)
- Hosting hosting hosting bla bla bla

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