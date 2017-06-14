Laravel 5.4 <br>
To run the application, rename the file ".env.example" to ".env" and configure DB connection in it. <br>
Then execute "php artisan migrate", "php artisan serv" command.
<br><br><br><br>

{<br>
"method": "OPTIONS",<br>
"url": "/api",<br>
"description": "Get this options"<br>
},<br>
  {<br>
"method": "GET",<br>
"url": "/api/urls",<br>
"description": "Get all server response data"<br>
},<br>
{<br>
"method": "GET",<br>
"url": "/api/urls/{$id}",<br>
"description": "Get specific server response data"<br>
}<br>