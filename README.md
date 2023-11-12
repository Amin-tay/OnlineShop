<p align="center"><img src="./storage/app/public/Img/logoText.png" width="400" alt="Logo">
</p>


## Online Shop 

This is a simple online shop project, which allows you to add Categories, add Products, create discount codes, add products to cart and order products. 


# Running the project
- clone the code
- run `npm install`
- run `composer install `
- rename `.env.example` file to `.env`
- run `npm run dev`
- run `php artisan key:generate`
- run `php artisan 
migrate --seed` (some inital data are provided)
- run `php artisan storage:link`
- run `php artisan serve`

You can use `admin@gmail.com`  and `password` to login as an admin 
and also `user1` and `password` to login as a normal user.