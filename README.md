## About

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

Download the credentails.json and Placed the credentials.json in a root directory
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/8a0475eb-7d70-45d2-8677-c1e7b3d986aa)

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
MAIL_USERNAME=[Your emial address] #add this email to SendInvitation.php controller to send emails
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
php artisan migrate
php artisan serve
```

### Steps to Create Calendar Event
- Execute get-url api and copy the data url and select account to authenticate
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/d8562d36-c0bd-402a-a542-3c1dda196dac)

- Copy the code from url
![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/d1e776d0-69d9-4faf-b4be-9af8b9e38f57)

- Excute get token api and to get token second time your need pass only employer id

![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/df309d9b-5c7f-4bba-b92e-5c56c1421494)

- Send invitation by executing this api:
  ![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/170d3902-a21f-40a8-9c3d-6f77378a29de)

- To check if token is expire:
  ![image](https://github.com/Adnan913/Google-Calendar-Interview-Scheduler-PHP/assets/54793380/e1c8ccaf-9885-49e1-a4dc-523bdc3804bc)



Check emial you will receive an invitation email


### For any reason user disconnected the application from google security 
Then sending invitation will send an email to authenticate again

### For more useful tips and trick follow 
[github: Adnan Sami](https://github.com/Adnan913)
[linkedin:Adnan Sami](https://www.linkedin.com/in/adnansami9134/)


## License
Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
