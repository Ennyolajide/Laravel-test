<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>



## About The Project (Laravel Test)

This is a Coding Exercise solution written by - [Olajide Eniseyin](https://www.linkedin.com/in/eniseyin-olabode/)

- Unit Test in this project uses a json file (public/test.json) for testing
- The Json file contains array of Emails as described in the Exercise document
- Rename .env.example file to .env to scaffold the basic configuration file 
- Make sure you have Redis installed
- Ensure is set the value of the following in env file
  ```javascript 
  QUEUE_CONNECTION=redis
  ```
- Set Database connection
- Run 
  - ```bash
    composer install
    ```
  - ```bash
    php artisan migrate
  
- For Unit Test (EmailJobDispatchTest) & (EmailListTest) Run
  - ```bash
    php artisan test
    ```
  
