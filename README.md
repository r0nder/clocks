**How to run**

`composer install`

`php -S localhost:8000`

`http://localhost:8000/`

**Description**

The backend uses Symfony MicroKernel as fast and small solution. For flexibility, timezones configured 
in `parameters.yml`. It is possible to add/remove cities (in one place) which will be displayed 
on frontend. Backend returns json with prepared date and time (in timezone of city). Frontend use 
jqClock lib for displaying digital clocks.


Twig was not used by intention, to create an application in a modern way - frontend lives independently 
and communicates with backend through API. Another way is to add a route and render index.html through Twig.