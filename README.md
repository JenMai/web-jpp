# Jean-Pierre Parc

## Contributors
* Maxime D.
* Sébastien R.
* Jennifer M.

## Details

JPP is a fictitious amusement park website featuring attractions and on-site hotels and restaurants.

An admin page (`/admin`) is available to manage them, as well as users:

`username: admin - pwd: admin`

NB: This project has not been tested outside of dev environment.

## Requirements
* PHP 7.1
* Composer
* Sqlite

## How to install
### Push
`$git clone https://github.com/JenMai/web-jpp.git`
### Set up
`$composer install`

In .env (located in the root) change this line:

`DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"`

for:

`DATABASE_URL="sqlite:///%kernel.project_dir%/var/app.db"`

# TODOs

Absent or partially implemented features:
* Users
  * Users can sign in, log in/out, but can't review nor rate attractions
* Reviews
  * Comments are linked to attraction, yet as said before, users can't write any yet.
* Tickets
  * A draft has been written (TODO) yet not implemented within the core project
* Map
  * Because it would have been a cool feature.


