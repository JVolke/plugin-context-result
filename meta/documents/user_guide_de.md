# Plugin ContextResult

Dieses Plugin erlaubt es die Context-Klassen von Ceres zu erweitern und ResultFields zu überschreiben. Das Plugin richtet sich dabei an alle, die CeresVanilla direkt vom Marketplace nutzen und keine Möglichkeit haben eigene Dateien zum Plugin hinzuzufügen. Generell kann dieses Plugin aber mit jedem Theme verwendet werden.

## Wie richte ich das Plugin ein?
Zuerst muss das Plugin hier im Marketplace "gekauft" werden. Anschließend sollte das Plugin unter **Plugin => Plugin Übersicht** angezeigt werden, wenn Ihr in den Filter Einstellungen des aktuellen Plugin-Sets folgendes Auswählt
- Herkunft = Marketplace
- Installiert = Nicht Installiert

Nun kann man in der Spalte Aktion auf **Plugin Installieren** klicken, damit das Plugin installiert wird.

Wurde das Plugin installiert sollte für diese Plugin die Position festgelegt werden. Die Position sollte dabei so gewählt werden, dass sich dieses Plugin zwischen IO und Eurem Theme einordnet. Beispielsweise könnt Ihr folgende Positionen verwenden:

- Ceres = 910
- Theme-Plugin = 911
- ContextResult = 998
- IO = 999

Nun muss das Plugin-Set noch einmal gespeichert werden, damit das Plugin bereitgestellt wird.

## ResultFields überschreiben
### Einführung
Unter Ceres gibt es drei Dateien im Ordner /resources/views/ResultFields. Diese drei Dateien sind dafür verantwortlich, welche Artikeldaten im Theme zur Anzeige oder zur weiteren Bearbeitung zur Verfügung stehen. Man kann hier zusätzlich Felder hinzufügen, um beispielsweise den Netto-Bestand eines Artikels anzeigen zu können.

Die Daten die hier zusätzlich angezeigt werden können sind aber begrenzt. Es können nur Daten erweitert werden, welche sich im ElasticSearch-Index befinden. Welche Daten hier verfügbar sind, könnt Ihrem im Forum im Bereich Artikel nachfragen.

### Einstellung
In der Plugin-Konfiguration könnt Ihr unter Basis-Einstellungen eine oder mehrere der Bereiche auswählen, für die Ihr weitere Daten benötigt. Zur Auswahl stehen:

<table>
<thead>
<th>Plugin-Einstellung</th>
<th>Der betroffene Ceres-Bereich</th>
</thead>
<tr>
<td>Die Artikel-Ansicht</td>
<td>Bereich Item im Ceres</td>
</tr>
<tr>
<td>Die Artikel-Kategorie- und Sucherergebnisseiten</td>
<td>Bereich Category/Item und ItemList im Ceres</td>
</tr>
<tr>
<td>Die Warenkorbansicht</td>
<td>Bereich Basket im Ceres</td>
</tr>
</table>

_Hinweis:_
Leider greifen diese Einstellungen noch nicht überall, so werden Artikellisten, wie das Cross Selling aktuell noch nicht bei diesen _Overrides_ berücksichtigt.

### Eigene Werte ergänzen
Um jetzt eigene Werte, wie den Bestand, zu ergänzen muss man nachdem man den Bereich gewählt hat das Plugin in der Übersicht öffnen und geht hier auf Dateien. Jetzt wählt man beispielsweise die SingleItem.fields.json Datei aus und öffnet diese. Nun fügt man für den Bestand folgende Zeile zwischen den Werten ein:

    "stock.*",

**Wichtig**: Folgen Werte muss hinter dem eigenen Wert noch ein Komma gesetzt werden. Setzt man dagegen den eigenen Wert ans Ende der Datei, dann kann das Komma weggelassen werden. Alle Werte müssen aber innerhalb der eckigen Klammer stehen.

Hat man die Werte geändert, dann muss man das Plugin einmal neu bereitstellen, damit die eigenen Werte auch greifen.

## Context-Klassen erweitern
### Einführung
Die Context-Klassen dienen der Aufbereitung der Daten, die durch IO bereitgestellt werden. Außerdem können die Context-Klassen auch dafür verwendet werden, mit den verfügbaren Daten weitere Abfragen zu machen. Welche Context-Klassen von Ceres in welchen Bereich verwendet werden sieht man am besten in der  werden alle
[ServiceProvider.php von Ceres in der Variable $templateKeyToViewMap](https://github.com/plentymarkets/plugin-ceres/blob/stable/src/Providers/TemplateServiceProvider.php) Context-Klassen einzelnen Template Bereichen zugeordnet.

Ich habe mich hier auf 5 Context-Klassen beschränkt, erweitert werden können

* GlobalContext
* CategoryContext
* CategoryItemContext
* SingleItemContext
* ItemSearchContext

Für die meisten dürfte aber das Erweitern des SingleItemContext bereits ausreichend sein.
**Die Erweiterungen enthalten aktuell nur den Basis-Code um die bestehenden Context-Klassen zu erweitern. Man muss also eigene Funktionen noch einfügen.**

### Einstellung
In der Plugin-Konfiguration findet Ihr unter den ResultFields den Bereich Ceres Context überschreiben. Hier könnt Ihr einen oder mehrere Context-Klassen auswählen, die Ihr nutzen wollt.

<table>
<thead>
<th>Plugin-Einstellung</th>
<th>Der betroffene Ceres-Context</th>
</thead>
<tr>
<td>Context für SingleItem erweitern</td>
<td>SingleItemContext</td>
</tr>
<tr>
<td>Context für Content Kategorien erweitern</td>
<td>CategoryContext</td>
</tr>
<tr>
<td>Context für Artikel Kategorien erweitern</td>
<td>CategoryItemContext</td>
</tr>
<tr>
<td>Globalen Context erweitern</td>
<td>GlobalContext</td>
</tr>
<tr>
<td>Context für Suchergebnisseite erweitern</td>
<td>ItemSearchContext</td>
</tr>
</table>

__Hinweis:__
Im Context für die Artikel-Ansicht ist bereits die Ausgabe für Freitext-Felder integriert. Wenn man also in seinem Theme auf Freitext-Felder zugreifen möchte, dann kann man dies über

    {{ freeField.free1 }}

für das Freitext-Feld 1 realisieren.
