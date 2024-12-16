# LetzTalk

This project is an old school project from 2018 and developed by two people. The goal is to create a mockup of a social media website. This project was created as a WAMP project and uses Apache, HTML and PHP.

## How to run

### Setting up the database

This project uses MySQL. To set up the database needed for the project, create a database, then set up the tables with the file projet.sql (soource src/projet.sql). Go to the file src/fonctions/structure.php and change the variables from line 4-7 with the appropriate information.

### Running the Website

This project was a WAMP project, so to use it you need to install WAMP, then copy the src directory inside the www directory of WAMP and rename it to LetzTalk. Activate WAMP server and go to localhost/LetzTalk.

## Issues and how to solve them

### Send Mail

There are is an issue with the fonction sendmail() in the file fonctions/accueil/inscrilogin.php. The fonction is currently deactivated. To reactivate, uncomment line 78-79 and change F to T line 121.

### Link

Some links behave weirdly.