## About Laravel

Using Google Calendar Api service to create events and send invitation to specified user (invitation includes: Calendar remaindar and google meet link )
- This project can create canlendar events.
- Authenticate user via google to create calendar event and goole meet link.
- Refresh token automatically when access token is expired.

## Requirements
* [PHP 7.4 or higher](https://www.php.net/)


## Installation ##

## Clone the repository
["Google Calendar Interview Scheduler"](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP.git)

You can use **Composer** or simply **Download the Release**

### Composer

The preferred method is via [composer](https://getcomposer.org/). Follow the
[installation instructions](https://getcomposer.org/doc/00-intro.md) if you do not already have
composer installed.

Once composer is installed, execute the following command in your project root to install this library:

```sh
composer install
```

### How to obtain the credentials to communicate with Google Calendar
The first thing you’ll need to do is get credentials to use Google's API. I’m assuming that you’ve already created a Google account and are signed in. Head over to [Google API console](https://console.cloud.google.com/apis/dashboard) and click "Select a project" in the header.

![1](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/663cee99-55e5-4629-9643-d9116f82c421)

Next up we must specify which APIs the project may consume. From the header, select "Enable APIs and Services".

![2](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/0554c3f2-154d-4370-ab0a-a496a087f4f8)

On the next page, search for "Calendar" and select "Google Calendar API" from the list.

![3](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/378ddf38-749a-4484-ac09-b1b750113dc6)

From here, press "Enable" to enable the Google Calendar API for this project.

![4](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/d63938ad-0154-4445-83d9-c8b847b178f3)

Now that you've created a project that has access to the Calendar API it's time to download a file with these credentials. Click "Credentials" in the sidebar and then press the "Credentials in APIs & Services" link and click on create credentails then click on Oauth client id.
Fill out the form.

![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/b4ef7350-476b-45c3-857f-cc61d9727c43)

Select the external user type and click on create button.
Then publish the application

![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/ae71850f-6f08-4324-ab0b-87a59aabc4fb)

After complete the form, Then publish the application
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/40cc0375-e33a-456c-b86e-3261c0b36a93)

Download the credentails.json 
###
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/ed492c59-b33f-4b59-ab58-bc8f1e5cb488)

Placed the credentials.json in a root directory
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/298a1abb-4366-42a4-99bd-cc9f29da2959)

### Configure .ENV file

```sh
##Setup database)
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=


MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=[Your emial address]
MAIL_PASSWORD=[Your password]
MAIL_ENCRYPTION=ssl


##(Set the credential using credentails.json)
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT=
GOOGLE_APPLICATION_NAME=
```

### Project is all set
Start the project using command:
```sh
php artisan serve
```













































### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**

- **[Cubet Techno Labs](https://cubettech.com)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[Many](https://www.many.co.uk)**
- **[Webdock, Fast VPS Hosting](https://www.webdock.io/en)**
- **[DevSquad](https://devsquad.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[OP.GG](https://op.gg)**
- **[WebReinvent](https://webreinvent.com/?utm_source=laravel&utm_medium=github&utm_campaign=patreon-sponsors)**
- **[Lendio](https://lendio.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
