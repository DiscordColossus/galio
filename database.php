<?php
/**
 * Łączenie z bazą danych
 * 
 * @return PDO $db_conn
 */
function dbConnect() {
    try {
        /**
         * Użycie biblioteki PDO.
         * 
         * Biblioteka ta pozwala w prosty sposób połączyć z bazą danych dowolnego typu.
         * Tutaj - tworzymy zmienną $db_conn, która zawiera nową instancję obiektu PDO z odpowiednimi parametrami:
         * 
         * ---
         * 
         * @param string $dsn
         * *Data Source Name*, czyli miejsce skąd pobierane są dane.
         * Tutaj należy wprowadzić dane wymagane przez sterownik bazy danych.
         * W naszym przypadku sterownikiem jest "mysql", co odpowiada połączeniu z serwerem MySQL lub MariaDB (oba rodzaje baz danych działają na tym samym silniku).
         * Sterownik od wymaganych parametrów oddzielamy dwukropkiem, a po nim kolejno wprowadzamy parametry. W naszym przypadku są to: host (serwer baz danych) oraz dbname (nazwa bazy danych).
         * 
         * Domyślnie, jak w naszym przypadku serwer baz danych jest uruchomiony na tej samej maszynie, na której tworzymy stronę. W takim przypadku należy w parametrze host wpisać "localhost". W innym przypadku będzie to dokładny adres serwera baz danych.
         * W parametrze dbname wprowadzamy dokładną nazwę bazy danych, jaką utworzyliśmy (lub została nam przyznana przez administratora serwera).
         * Dodatkowym parametrem jest być port, gdzie wprowadzimy port na serwerze, który odpowiada na żądania kierowane do serwera baz danych. Domyślnym portem dla MySQL jest 3306, natomiast MariaDB - 3307. Parametr "port" wprowadzamy jedynie wtedy, kiedy te wartości są ustawione inaczej.
         * 
         * @param string $username
         * W ten parametr należy wpisać nazwę użytkownika, który ma dostęp do bazy danych.
         * Dobrą praktyka jest nadanie użytkownikowi nazwy takiej, jak baza danych z którą będzie on pracował.
         * Dodatkowo - taki użytkownik powinien mieć ograniczone uprawnienia nie tylko do serwera, ale także do samej bazy danych.
         * Powinien móc pobierać dane, aktualizować je i usuwać - inne czynności (takie jak zmiana struktury bazy czy tworzenie backupów) nie powinny być dla takiego użytkownika dostępne - te dzialania powinien podejmować administrator systemu.
         * 
         * @param string $password
         * Ostatni parametr, to hasło użytkownika. Należy utworzyć możliwie najbezpieczniejsze hasło (można skorzystać z generatora haseł).
         * 
         * ---
         * 
         * Użycie składowych obiektu w PHP następuje poprzez operator ->. Dzięki temu operatorowi wskazujemy niejako na konkretną składową obiektu, a następnie wywołujemy ją.
         * W tym przypadku wywołaliśmy metodę setAttribute(), która przyjmuje parametry związane z działaniem serwera. Ustawienie ERRMODE na EXCEPTION pozwala przekierować domyślny kanał wyświetlania wyjątków na klasę PDOException, czyli pochodną od Exception (obsługa wyjatków).
         * Dzięki temu możemy "łapać" wyjątki poprzez blok try-catch.
         */
        $db_conn = new PDO('mysql:host=localhost;dbname=zsht', 'zsht', '1234');
        $db_conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
        /**
         * Zgodnie ze specyfikacją klasy Exception, metoda getMessage() pobiera wiadomość wysłaną przez przechwycony wyjątek.
         */
        echo $e->getMessage();
    }
    /**
     * Słowo kluczowe *return*  zwraca w tym przypadku obiekt po połączeniu z bazą danych.
     * Dzięki zwróceniu tej zmiennej mamy do niej dostęp na zewnątrz funkcji łączącej.
     */
    return $db_conn;
}
?>