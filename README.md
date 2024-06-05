# ToDo-Backend
ToDo-Backend

## Projekt ausführen
<details closed>
    <summary>Projekt Lokal ausführen</summary>
    
    copy env .env

    composer install

    php spark db:create todos

    php spark migrate

    php spark db:seed TodoSeeder

    php spark shield:setup
    --n
    --n
    --n
    --y

    php spark serve
</details>

## Dokumentation
Die Dokumentation finden Sie hier: 
https://documenter.getpostman.com/view/32715719/2sA3QzZTRq#63616509-26fa-481d-aed0-7742caae67da

## Entity-Relationship-Modell
Unser ERD finden Sie hier:
[Link]

## Feedback
Unser Feedback finden Sie hier:
[Link]

## Tests
Die Dokumentation der Tests finden Sie hier: 
[Link]

## Actions
<details closed>
    <summary>FTP Deploy</summary>
    Wir haben FTP Deploy verwendet, um automatisch die commits auf den FTP Server zu pushen
    
    https://github.com/marketplace/actions/ftp-deploy
</details>

## Contributors
@werlen-nevio - Werlen Nevio

@tholz88 - Holzer Tobias

## ToDo's
- [x] API Dokumentation
- [ ] Persönliches Feedback zu Projektarbeit
- [ ] ERD & Dokumentation DB-Modell
- [x] Korrekte Datenfelder & Beziehungen
- [x] Migration-Script
- [x] Seed-Skripts
- [x] API für "TODO Aufgaben" und "TODO Kategorien"
- [x] Datenübergabe per JSON
- [x] Rückgabewert per JSON
- [x] GET-Request haben zusätzliche Möglichkeiten die als Zusatzparameter per URL definiert werden können
- [x] HTTP Anfragen (GET, POST, PUT/PATCH, DELETE)
- [x] Korrekte Prüfung der Daten
- [x] Zugriff auf API nur mit gültigem API-Key
- [x] Authentifizierung mittels JWT
- [ ] Log-File
- [ ] Unit Tests
- [ ] Dokumentation der Tests
- [ ] E-Mail senden (Zusatzfunktion)
