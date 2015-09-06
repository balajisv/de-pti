TomiSoft DE-PTI
===============

Ez a repository tartalmazza a http://users.atw.hu/de-pti webhely teljes forráskódját.
A szoftver a Yii Framework 1-re épül, amely a /framework könyvtárban található.

A repository tartalma
---------------------
- Yii Framework 1
- A DE-PTI teljes kódja
- A DE-PTI adatbázisterve MySQL Workbench formátumban
- Telepítési dokumentáció (azaz a README.md)

Üzembe helyezési előfeltételek
------------------------------
- Egy webszerver, pl. Apache
- Egy MySQL szerver
- PHP futtatókörnyezet, legalább 5.3-as verzió
- MySQL Workbench (az üzembe helyezés erejéig)
- Egy tetszőleges plain-text szövegszerkesztő

Üzembe helyezés menete
----------------------
1. A MySQL Workbench-ben forward engineering-el elkészíttetjük az adatbázist elkészítő scriptet, amit a MySQL szerveren végrehajtunk.
2. A fájlokat bemásoljuk a webszerver könyvtárába.
3. A protected/config/main.php-ben a Yii Framework 1 dokumentációja alapján beállítjuk az adatbázis-kapcsolatot, illetve a params altömb értékeit.
4. Létrehozunk egy upload nevű mappát a protected könyvtárral egy szinten.
5. ???
6. Profit!

Licenc
------
A szoftver csak a szerző engedélyével használható fel. A szoftver által üzemeltetett oldalakért a szerző semmilyen
felelősséget nem vállal. A szoftver által üzemeltetett oldalakon a szoftver készítőjének a nevét fel kell tüntetni.
A szoftver ezen feltételek mellett szabadon módosítható. A Yii Framework 1 esetében a mindenkori érvényes licenc a
http://yiiframework.com webhelyen található.

Kapcsolat
---------
Sinku Tamás (sinkutamas@gmail.com)
