<?php
require_once('vendor/autoload.php');

$client = new \GuzzleHttp\Client();

$response = $client->request('GET', 'https://api.themoviedb.org/3/movie/99?language=en-US', [
  'headers' => [
    'Authorization' => 'Bearer eyJhbGciOiJIUzI1NiJ9.eyJhdWQiOiJlOWI4YzNhOWE0NjYwZmNhYWEwMWRkYWY2ZWE5OTMxMCIsIm5iZiI6MTcyODQ0MjQ0MS40NTY3OTcsInN1YiI6IjY3MDUxZTZlOThkZjhlYTAxNTFkNGIxMSIsInNjb3BlcyI6WyJhcGlfcmVhZCJdLCJ2ZXJzaW9uIjoxfQ.X9UGhWaP2KNCU1AKEXnNTM-X8hTD5GlSabBiWaU5Czo',
    'accept' => 'application/json',
  ],
]);

echo $response->getBody();