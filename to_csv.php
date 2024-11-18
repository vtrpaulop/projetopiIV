<?php

$file = fopen('movies.csv', 'w');

try {
    $pdo = new \PDO('mysql:host=127.0.0.1;port=3306;dbname=piiv', 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
    );
    $query = $pdo->query('SELECT * FROM piiv.movies');

    $columns = array_keys($query->fetch());
    fputcsv($file, $columns);


    while ($row = $query->fetch()) {
        fputcsv($file, $row);
    }

    fclose($file);
} catch (\PDOException $e) {
    echo 'Database error:'.$e->getMessage();
    echo PHP_EOL;
} catch (\Exception $e) {
    echo 'Another errors';
    echo PHP_EOL;
}
