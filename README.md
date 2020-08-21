# tasks-api
tasks-api

API documentation could be found
[here](https://documenter.getpostman.com/view/782282/T1LTgR22).

Note: api uses basic auth.
Use `{your-host.name}/register` to create a new user and simply add its credentials to the request.

Don't forget to run `php artisan migrate` to create db tables.

Note: [supervisor](https://laravel.com/docs/7.x/queues#supervisor-configuration) was used in order to run image conversion job asynchronously.

To install and configure supervisor:

```
sudo apt-get install supervisor
sudo touch /etc/supervisor/conf.d/laravel-worker.conf
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
```

Add the following config inside the file using the correct path:

```
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /path-to/artisan queue:work database --sleep=3 --tries=3
autostart=true
autorestart=true
numprocs=2
redirect_stderr=true
stdout_logfile=/path-to/storage/logs/worker.log
stopwaitsecs=3600
```
After:

```
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
```
