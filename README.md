# ToDo-Backend
ToDo-Backend

## Projekt ausführen
<details closed>
    <summary>Projekt ausführen</summary>
    
    copy env .env

    composer install

    composer update

    php spark db:create todos

    php spark migrate

    php spark db:seed todos

    php spark shield:setup
    --n
    --n
    --n
    --y

    php spark serve
</details>

## Actions
<details closed>
    <summary>FTP Deploy</summary>
    Wir haben FTP Deploy verwendet, um automatisch die commits auf den FTP Server zu pushen
    
    https://github.com/marketplace/actions/ftp-deploy
</details>
