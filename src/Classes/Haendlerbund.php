<?php
namespace Lukasbableck\ContaoHBRechtstexteBundle\Classes;

use Contao\CoreBundle\Monolog\ContaoContext;
use Monolog\Level;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Haendlerbund {
	public const string BASE_URL = 'https://www.hb-intern.de/www/hbm/api/live_rechtstexte.htm';
	public const string API_KEY = '1IqJF0ap6GdDNF7HKzhFyciibdml8t4v';

	public function __construct(private HttpClientInterface $client, private LoggerInterface $contaoGeneralLogger) {
	}

	public function request(string $docID, string $language, string $accessToken): string {
		$url = self::BASE_URL.'?did='.$docID.'&AccessToken='.$accessToken.'&APIkey='.self::API_KEY.'&lang='.$language;
		$response = $this->client->request('GET', $url);
		if (200 === $response->getStatusCode()) {
			return $response->getContent();
		}

		$this->contaoGeneralLogger->error('Händlerbund API request failed with status code '.$response->getStatusCode(), ['contao' => new ContaoContext(__METHOD__, ContaoContext::GENERAL)]);

		return '';
	}
}
