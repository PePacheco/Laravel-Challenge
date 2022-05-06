
## Steps to run the application

# 1# Step
Change the name of the .env.example file to .env

# 2# Step
Run this command
```
docker-compose up -d
```

# 3# Step
Run this command
```
php artisan migrate
```

# 4# Step
Run this command
```
php artisan command:import
```

# 5# Step
Wait untill a message appears on your terminal pointing that the processed was done successfully