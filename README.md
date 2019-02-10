# jwt-laravel
Laravel + JWT + Google/Facebook Auth

ინსტრუქცია.

1. composer install
2. შექმენი .env ფაილი და გადააკოპირე .env.example-იდან კონტენტი
3. შემდეგი ფილდები შეავსე შენი ბაზის მონაცემებით:
   DB_DATABASE=homestead
   DB_USERNAME=homestead
   DB_PASSWORD=secret
4. php artisan key:generate
5. Facebook-ით დალოგინებისათვის შექმენი Facebook აპლიკაცია. აპლიკაციის id და secret ჩააკოპირე .env ფაილში FB_ID და FB_SECRET key-ებზე.
6. Google-ით დალოგინებისთვის შექმენი Google აპლიკაცია. აპლიკაციის client id ჩააკოპირე .env ფაილში GOOGLE_CLIENT_ID key-ზე.
7. php artisan migrate
