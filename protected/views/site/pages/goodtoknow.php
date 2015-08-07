<?php

$this->pageTitle=Yii::app()->name . ' - Hasznos tudnivalók';
$this->breadcrumbs=array(
	'Hasznos tudnivalók',
);

Yii::app()->clientScript->registerMetaTag('Hasznos egyetemi tudnivalók a debreceni programtervező informatikus hallgatók számára.', 'description');
Yii::app()->clientScript->registerMetaTag('vizsgajelentkezés, vizsgaleadás, kreditbüntetés, hallgatói jogviszony', 'keywords');

?>

<style type="text/css">
	div.reference {
		font-style: italic;
		font-size: 8pt;
		color: #A6A6A6;
	}
</style>

<h1>Hasznos tudnivalók</h1>

<div class="flash-error">
	<b>Figyelem!</b>
	Az itt leírt információk csupán tájékoztató jellegűek, a webhely tulajdonosa nem vállal felelősséget az
	esetleges pontatlanságokért és az ebből bekövetkezett károkért. A Debreceni Egyetem fenntartja a jogot
	az adatok megváltoztatására, így a Debreceni Egyetem dokumentumai és szabályzatai az irányadóak.
</div>

<p>
	Az oldal tartalma:
	<ul>
		<li><a href="#takeexam">Vizsgára történő jelentkezés és leiratkozás határideje</a></li>
		<li><a href="#examcosts">A vizsgákkal kapcsolatos esetleges költségek</a></li>
		<li><a href="#degreereqs">A diploma megszerzésének feltételei</a></li>
		<li><a href="#degreevalue">Hányas diplomám lesz?</a></li>
		<li><a href="#creditpunishment">Kreditbüntetés - mikor kell fizetnem és mennyit?</a></li>
		<li><a href="#kickoff">Mikor szűnhet meg a hallgatói jogviszonyom?</a></li>
	</ul>
</p>

<a name="takeexam"></a>
<h3>Vizsgára történő jelentkezés és leiratkozás határideje</h3>
<p>
	<div class="reference">Tanulmányi- és Vizsgaszabályzat, 7§ (3)</div>
	<ul>
		<li>Vizsgára történő <b>feliratkozás</b> a vizsgát megelőző munkanap <b>12:00</b> óráig lehetséges</li>
		<li>Vizsgáról történő <b>leiratkozás</b> a vizsgát megelőző munkanap <b>00:00</b> óráig lehetséges</li>
	</ul>
</p>

<a name="examcosts"></a>
<h3>A vizsgákkal kapcsolatos esetleges költségek</h3>
<p>
	<div class="reference">Hallgatói térítési és juttatási szabályzat, 3. sz. melléklet</div>
	<ul>
		<li>
			Amennyiben egy tárgyból az első két vizsgalehetőséggel sem sikerül
			teljesítened a tárgyat, a harmadik és további vizsgalehetőségekért
			vizsgánként <b>2000 Ft</b>-ot kell fizetned. Ez független attól,
			hogy egy vagy több vizsgaidőszakban mész vizsgázni az adott tárgyból.
			Ezt a tételt <b>neked kell kiírnod</b> a Neptunban a "Pénzügyek" menü
			"Befizetés" menüpontjának "Tétel kiírása" lehetőséggel. A rendszer
			addig nem engedi felvenni a vizsgát, amíg ezt a tételt nem teljesítetted.
		</li>
		<li>
			Amennyiben felveszel egy vizsgát, de nem mész el rá, <b>4000 Ft</b>-ot
			kell fizetned. Ezt a tételt a Tanulmányi osztály írja ki a vizsgaidőszak
			letelte után.
		</li>
	</ul>
</p>

<a name="degreereqs"></a>
<h3>A diploma megszerzésének feltételei</h3>
<p>
	<div class="reference">DE-PTI fehér füzet</div>
	<ul>
		<li>
			180 kredit teljesítése a következő eloszlással:
			<ul>
				<li>120 kredit természettudományos alapozó és kötelező szakmai tárgy</li>
				<li>
					29 kredit választható szakmai tárgy
					<br/>
					A választható szakmai tárgyak egy része sávokra van osztva. Az A, B, C, D és S sávok
					mindegyikéből legalább egy tárgyat kötelező választani. A 29 kredit eléréséhez szükséges
					többi kreditet a sávokból választott további tárgyak és az Informatikai Kar által a félévek
					elején meghirdetett szakmai tárgyak teljesítésével lehet megszerezni.
				</li>
				<li>5 kredit szabadon választható tárgy a természettudomány területéről</li>
				<li>6 kredit szabadon választható tárgy nem a természettudomány területéről</li>
				<li>20 kredit szakdolgozat</li>
			</ul>
		</li>
		<li>Legalább egy darab B2 szintű komplex államilag elismert nyelvvizsga, vagy azzal egyenértékű érettségi bizonyítvány</li>
		<li>240, illetve 320 óra (2014/15-ös tanávben kezdőktől) igazolt szakmai gyakorlat</li>
		<li>2 félév testnevelés teljesítése</li>
	</ul>
</p>

<a name="degreevalue"></a>
<h3>Hányas diplomám lesz?</h3>
<p>
	<div class="reference">DE-PTI fehér füzet, Tanulmányi- és Vizsgaszabályzat 27§ (9)</div>
	A diplomajegy a következő tantárgyakból szerzett jegy, valamint a záróvizsga során szerzett jegy átlagából
	kerül kiszámításra:
	<ul>
		<li>Magas szintű programozási nyelvek 2</li>
		<li>Operációs rendszerek 2</li>
		<li>Adatbázisrendszerek</li>
	</ul>
	A diplomajegy a kiszámított átlag alapján:
	<ul>
		<li>Kiváló (4,81 - 5,00)</li>
		<li>Jeles (4,51 - 4,80)</li>
		<li>Jó (3,51 - 4,50)</li>
		<li>Közepes (2,51 - 3,50)</li>
		<li>Megfelelt (2,00 - 2,50)</li>
	</ul>
</p>

<a name="creditpunishment"></a>
<h3>Kreditbüntetés - mikor kell fizetnem és mennyit?</h3>
<p>
	<div class="reference">Hallgatói térítési és juttatási szabályzat, 3. sz. melléklet</div>
	Minden tárgynak, amit felveszel, kreditértéke van, amit a Tantárgyak menüpontban megtekinthetsz.
	Amennyiben egy tantárgyból nem sikerül teljesítened a végső követelményt, ami lehet:
	<ul>
		<li>aláírás megszerzése (nem sikerült teljesíteni, amennyiben az értéke "megtagadva")</li>
		<li>gyakorlati jegy (nem sikerült teljesíteni, amennyiben az értéke "1")</li>
		<li>kollokviumi jegy (nem sikerült teljesíteni, amennyiben az értéke "1")</li>
	</ul>
	akkor a Tanulmányi osztály kreditbüntetést ír ki. Ennek az értéke <b>a tárgy kreditértéke
	felszorozva 1500 Ft-tal</b>. Vagyis, ha pl. nem sikerül az "Informatika logikai alapjai" tárgy,
	amelynek kreditértéke 5, akkor 7500 Ft-ot fogsz fizetni.
	<br/>
	Jelenleg a kreditbüntetés <b>felső határa 18.000 Ft</b>, amely 12 elbukott kreditnek felel meg.
	Hiába buktál el ettől többet, mondjuk 15 kreditet, akkor is 18.000 Ft-ot kell majd kifizetned.
	<br/>
	A kreditbüntetést a Tanulmányi osztály a <b>szorgalmi időszakban írja ki</b>, és amíg nem teljesíted,
	addig <b>nem jelentkezhetsz vizsgára</b> vizsgaidőszakban. Befizetési határidejét nem veszik szigorúan,
	vagyis nem lesz belőle probléma, ha nem a Neptunban előírt határideig fizeted be (erősen javasolt
	minél hamarabb rendezni).
</p>

<a name="kickoff"></a>
<h3>Mikor szűnhet meg a hallgatói jogviszonyom?</h3>
<p>
	<div class="reference">
		Tanulmányi- és Vizsgaszabályzat, 3§ (10), (11), (12), (13)<br/>
		A Debreceni Egyetem Hallgatói Térítési és Juttatási Szabályzata, 29§ (10)
	</div>
	<ol>
		<li>Amennyiben a Neptunban a hallgatói státuszod a "Diplomát szerzett" értéket veszi fel</li>
		<li>
			Amennyiben egy tárgyból <b>3 tárgyfelvétel</b> vagy <b>6 vizsgaalkalom</b> után sem sikerül
			teljesítened a végső követelményt
		</li>
		<li>
			Amennyiben egy tanév két aktív féléve alatt nem sikerül teljesítened a két félév alatt megszerezhető
			ajánlott kreditmennyiség (ami 60 kredit) felét (vagyis 30 kreditet). Erről további információkat
			lentebb olvashatsz.
		</li>
		<li>Ha te önmagad megszűnteted a hallgatói jogviszonyodat</li>
		<li>Ha egymást követő két félévben sem iratkozol be regisztrációs héten, és még passzív félévet sem kérsz</li>
		<li>Ha a passzív félévet követően nem kezded meg a tanulmányaidat</li>
		<li>Nem teljesített fizetési kötelezettség esetén</li>
		<li>Fegyelmi határozat jogerőre történő emelkedése esetén</li>
	</ol>
	A 2) és 3) esetekben ugyanakkor lehetőséged van arra, hogy kérvényezd a hallgatói jogviszonyod
	visszaállítását, de csak <b>költségtérítéses</b> képzésre. Ezt követően 2 félév elteltével
	a KTB-nél kérvényezheted az államilag támogatott képzésbe történő visszavételedet.
	<br/>
	
	Tanulmányi- és Vizsgaszabályzat 3§ (10), részlet:
	<blockquote>
		Ha arról az államilag támogatott hallgatóról, aki tanulmányait az első évfolyamon 2007
		szeptemberében kezdte meg – majd ezt követően felmenő rendszerben -, a tanév végén a
		kar megállapítja, hogy az utolsó két aktív félévben nem szerezte meg legalább az
		ajánlott tantervben előírt kreditmennyiség ötven százalékát, tanulmányait a következő
		tanévben csak a költségtérítéses képzésben folytathatja. Ezen átsorolással érintett
		hallgatók száma a tanévben a karok államilag támogatott képzésben résztvevő
		hallgatóinak 15 százalékáig terjed. A hallgató államilag támogatott vagy költségtérítéses
		képzésbe való besorolása egy tanév időtartamra szól.
	</blockquote>
</p>