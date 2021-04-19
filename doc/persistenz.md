## Persistenz

Dieses Dokument beschreibt wie Daten in der Anwendung gespeichert werden.

### Erhobene Daten

Folgende Datensätze werden für jede Messgröẞe durch die Anwendung erfasst:

* die Daten der letzten 24 Stunden (minimales Intervall 4 Minuten)
* die Daten der letzten 31 Tage (minimales Intervall 48 Minuten)
* die Daten des letzten Monats (minimales Intervall 48 Minuten)
* die Daten der letzten 365 Tage (minimales Intervall 10 Stunden)
* die Daten des letzten Jahres (minimales Intervall 10 Stunden)

Das minimale Intervall ist jeweils so gewählt, dass die maximale Menge an
gespeicherten Daten vorher bekannt und eine ganze Zahl ist.

### Speicherung der Daten

Die erhobenen Daten werden binär gespeichert.
Bei der Speicherung wird unterschieden zwischen Daten, die temporär
gespeichert (und nach einem gewissen Zeitraum verworfen) werden und Daten, die
permanent gespeichert werden.

#### Temporäre Daten

Die Daten der letzten 24 Stunden und der letzten 31 Tage werden in einem
Ringpuffer gespeichert.
Somit werden die ältesten Daten jeweils von den neusten Daten überschrieben.

#### Permanente Daten

Die Daten für einen festen Zeitraum (ein Monat oder ein Jahr) werden permanent,
dass heißt ohne die Intention einer Löschung gespeichert.

### Format der Daten

Das Format in dem die Daten gespeichert werden hängt von der Art der Daten ab.
Temporäre Daten werden in einem Ringpuffer gespeichert, permanente Daten werden
binär als Datei abgespeichert.

#### Ringpuffer

Jeder Eintrag in dem Ringpuffer umfasst 10 Bytes.
Alle Integer werden im little-endian Format gespeichert.
Der allererste Eintrag teilt sich auf in

* 4 Bytes für die Zahl der Elemente des Ringpuffers als 32-Bit Integer
* 4 Bytes für das aktuelle Element des Ringpuffers als 32-Bit Integer
* 2 Bytes als Padding

Für alle folgenden Einträge enthalten die ersten 8 Bytes dabei einen
signierten 64-Bit Integer im little-endian Format kodierten Unix-Zeitstempel.
Dieser beschreibt die Zeit, zu der die Daten erhoben wurden.
Die folgenden zwei Bytes enthalten einen signierten 16-Bit Integer mit den
erhobenen Daten.

#### Format von permanenten Daten

Das Format von permanenten Daten ähnelt dem des Ringpuffers.
Jeder Eintrag umfasst ebenfalls 10 Bytes.

Der allererste Eintrag enthält 

* 4 Bytes für die Zahl der Elemente des Ringpuffers als 32-Bit Integer
* 6 Bytes als Padding

Das Format der weiteren Einträge entspricht dem des Ringpuffers, die ersten
8 Bytes enthalten dabei jeweils einen signierten 64-Bit Integer im little-endian
Format kodierten Unix-Zeitstempel.
Dieser beschreibt die Zeit, zu der die Daten erhoben wurden.
Die folgenden zwei Bytes enthalten einen signierten 16-Bit Integer mit den
erhobenen Daten.