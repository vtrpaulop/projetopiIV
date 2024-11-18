<?php
require_once 'vendor/autoload.php';

$client = new \GuzzleHttp\Client;

/* O SQL para a criação da tabela Movies, lembrando que alguns campos são temporários */
$sql = <<<'SQL'
CREATE TABLE IF NOT EXISTS movies (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  original_title VARCHAR(255),
  original_language VARCHAR(255),
  overview LONGTEXT,
  genres JSON,
  status VARCHAR(255),
  popularity VARCHAR(255),
  adult VARCHAR(255),
  vote_average VARCHAR(255),
  vote_count VARCHAR(255),
  release_date DATE
);
SQL;

/* Cria uma nova instância do PDO */
$pdo = new \PDO('mysql:host=127.0.0.1;port=3306;dbname=piiv', 'root', '');

/* Executa o comando SQL de criação da tabela de movies */
$pdo->prepare($sql)->execute();

/* Cria o comando SQL para inserir os dados na tabela movies */
$sqlCreateMovie = 'INSERT INTO movies (name, original_title, original_language, release_date, overview, status, popularity, vote_average, vote_count, genres, adult)
VALUES (:name, :original_title, :original_language, :release_date, :overview, :status, :popularity, :vote_average, :vote_count, :genres, :adult)';

$chave = '';

for ($i = 0; $i < 3000; $i++) {
    sleep(1);
    try {
        $response = $client->request('GET', "https://api.themoviedb.org/3/movie/{$i}", [
            'headers' => [
                'Authorization' => "Bearer {$chave}",
                'accept' => 'application/json',
            ],
        ]);

        $json = json_decode($response->getBody(), true);

        /* https://www.php.net/manual/pt_BR/pdo.prepare.php */
        $pdo->prepare($sqlCreateMovie)->execute([
            'name' => $json['title'],
            'original_title' => $json['original_title'],
            'original_language' => $json['original_language'],
            'overview' => $json['overview'],
            'genres' => json_encode($json['genres']),
            'status' => $json['status'],
            'popularity' => $json['popularity'],
            'vote_average' => $json['vote_average'],
            'release_date' => $json['release_date'],
            'vote_count' => $json['vote_count'],
            'adult' => $json['adult']
        ]);

        echo '---------------------' . PHP_EOL;
        echo $i . ' - ' . $json['title'] . ': Inserido no Banco de Dados.';
        echo PHP_EOL;
        echo '---------------------' . PHP_EOL;
    } catch (\PDOException $e) {
        echo '---------------------' . PHP_EOL;
        echo $i . ': Erro envolvendo o Banco de dados na linha ' . $e->line . '.' . PHP_EOL;
        echo 'Mensagem: '. $e->message . PHP_EOL;
        echo '---------------------' . PHP_EOL;
    }
    catch(\GuzzleHttp\Exception\ClientException $e) {
        echo '---------------------' . PHP_EOL;
        echo $i . ': 404.'. PHP_EOL;
        echo '---------------------' . PHP_EOL;
    }
    catch(\Exception) {
        echo '---------------------' . PHP_EOL;
        echo $i . ': Erro desconhecido que não ligo.' . PHP_EOL;
        echo '---------------------' . PHP_EOL;
    }
}
>>>>>>> 3537e94 (hello world)
