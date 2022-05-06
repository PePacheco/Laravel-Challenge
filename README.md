
# Steps to run the application

## 0# Step
You need to have composer downloaded in you machine, then run this command in the project folder to download the dependencies
```
composer install
```

## 1# Step
Change the name of the .env.example file to .env

## 2# Step
Run this command to run the MySQL container
```
docker-compose up -d
```

## 3# Step
Run this command to execute the migrations
```
php artisan migrate
```

## 4# Step
Run this command to execute the process execution
```
php artisan command:import
```

## 5# Step
Wait untill a message appears on your terminal pointing that the process worked successfully

## 6# Step
Run this command to test the application
```
php artisan test
```
