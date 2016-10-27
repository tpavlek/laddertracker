Ladder Tracking System for Feardragon64's Ladder Heroes
==========================================================

This is both the frontend and backend system for [ladderhero.es](http://ladderhero.es), a weekly Starcraft competition
hosted by [feardragon64](https://twitter.com/feardragon64). All code and design was done by [Troy Pavlek](https://twitter.com/troypavlek).

Installation
--------------

First register `composer install` in the project root.

There are two main components to the system. The main application domain is all in the src/ folder, and a Laravel installation
that can speak with the domain is located in `web/`. You should point your webserver to the `web/public/` folder.

You'll need to copy `.env.example` to `.env` and edit the appropriate values. There are two environment files to do this
in, in the project root and in the `web/` folder.

In the `web/` folder register `php artisan migrate --seed` to migrate the initial database as well as seeding the admin user.

Using The System
-----------------

Any system controls that can be done in the web interface, can also be done via the command line. Run `php console.php` for
a list of commands and their descriptions.

To update the ladder id, change the static variables in `vendor/depotwarehouse/bnet-sc2-api/src/Apiservice.php`.

Testing
---------

```
phpunit
```

**Note**: The state of testing is not where I want it to be, not many tests are written currently. Proceed with caution.
