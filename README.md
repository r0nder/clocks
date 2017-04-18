**How to run**

`composer install`

`php -S localhost:8000`

`http://localhost:8000/`

**Description**

The backend uses Symfony MicroKernel as fast and small solution. For flexibility, timezones configured 
in `parameters.yml`. It is possible to add/remove cities (in one place) which will be displayed 
on frontend. Backend returns json with prepared date and time (in timezone of city). Frontend use 
jqClock lib for displaying digital clocks.