# TOPSTUDENTS App

## Versions
1. PHP 7.2
2. MYSQL 14.4
3. Yii2 2.0.13

## Manual installation
1. Composer install
2. Edit .env file
3. Run:
```bash
$ php console/yii migrate
$ chmod 777 -R frontend/web/assets
$ chmod 777 -R backend/web/assets
$ chmod 777 -R storage/web/source
$ chmod 777 -R frontend/runtime
```
4. Frontend base path - frontend/web
5. Backend base path - backend/web
6. Storage base path - storage/web
