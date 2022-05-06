
# Steps to run the application

## 1# Step
Change the name of the .env.example file to .env

## 2# Step
Run the command to run the MySQL container
```
docker-compose up -d
```

## 3# Step
Run the command to execute the migrations
```
php artisan migrate
```

## 4# Step
Run the command to execute the process execution
```
php artisan command:import
```

## 5# Step
Wait untill a message appears on your terminal pointing that the process worked successfully