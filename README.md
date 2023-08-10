專案使用教學
===
至專案web資料夾

複製.env.example檔案另取名為.env

.env檔案中修改:

APP_URL為專案URL路徑

DB_HOST為測試DB IP 位址

執行以下命令:
```
$ php artisan key:generate //產生專案APP_KEY
```
```
$ composer install //安裝 php套件
```

api 測試
===
```
127.0.0.1/api/convert?source=USD&target=JPY&amount=$170496.53
```

test 測試
===
至專案目錄下執行以下命令:
```
$ php artisan test
```