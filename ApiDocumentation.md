TomiSoft DE-PTI API dokumentáció
================================

A DE-PTI szoftver az általa kezelt adatok más alkalmazásokban történő felhasználásra a következő lehetőségeket biztosítja:
- JSON formátumban lekérdezhetőek a tantárgycsoportok és tantárgyak információi
- JSON formátumban lekérdezhetőek az egyes tantárgyakhoz feltöltött fájlok információi
- Adott fájl letöltése

A szoftver által adott minden dokumentum BOM nélküli UTF-8 karakterkódolású. A JSON dokumentumokban a speciális karakterek
unicode szekvenciákra lettek alakítva. A JSON dokumentumok string típusú objektumaiban a sortörést "\r\n" jelzi.

Tantárgycsoportok és tantárgyak lekérdezése
-------------------------------------------
URI: index.php?r=subject/getSubjectsJson

Paraméterek:
- Nincs

A válasz:
- sikeres működés esetén mindig egy JSON dokumentum (application/json)
- sikertelen működés esetén a viselkedés nem meghatározható

A válaszként kapott JSON dokumentum felépítése sikeres működés esetén:
```
{
   "groups":[
      {
         "group_id": A tárgycsoport azonosítója (int),
         "name": A tárgycsoport neve (string)
      },
	  ...
   ],
   
   "subjects":[
      {
         "subject_id": A tantárgy azonosítója (int),
         "group_id": A tárgycsoport azonosítója (int),
         "semester": Az ajánlott félév (int vagy null),
         "name": A tantárgy neve (string),
         "dependencies":[
            Azon tantárgyak azonosítói, amelyekre ez a tantárgy épül
         ],
         "files": A tantárgyhoz feltöltött fájlok száma (int),
         "events": A tantárgyhoz kiírt összes esemény száma (int)
      },
	  ...
   ]
}
```

A tantárgyhoz feltöltött fájlok információinak lekérdezése
----------------------------------------------------------
URI: index.php?r=file/getFilesJson&id=[subject_id]

Paraméterek:
- subject_id: (int) A tantárgy azonosítója

A válasz:
- sikeres működés esetén mindig egy JSON dokumentum (application/json)
- ha a megadott tantárgy nem létezik, akkor egy egyszerű szöveges dokumentum (text/plain)
- sikertelen működés esetén a viselkedés nem meghatározható

A válaszként kapott JSON dokumentum felépítése sikeres működés esetén:
```
[
   {
      "file_id": A fájl azonosítója (int),
      "uploader": A fájlt feltöltő felhasználó neve (string),
      "filename": A fájl neve a kiterjesztéssel együtt (string),
      "downloads": Hány alkalommal töltötték le a fájlt (int),
      "size": A fájl mérete bájtokban (int),
      "description": A fájl leírása (string)
   },
   ...
]
```

A válaszként kapott egyszerű szöveges dokumentum nem létező tantárgy esetén:
```
ERROR SUBJECT_NOT_FOUND
```

Fájl letöltése
--------------
URI: index.php?r=file/download&id=[file_id]

Paraméterek:
- file_id: (int) A letöltendő fájl azonosítója

A válasz:
- sikeres működés esetén egy fájlt kényszerít letöltésre
- nem létező fájl esetében HTTP 404 állapotkód és egy HTML dokumentum
- minden egyéb hiba esetében egy HTML dokumentum
