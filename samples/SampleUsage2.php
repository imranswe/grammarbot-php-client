<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$base_uri = 'http://api.grammarbot.io/v2';

$endpoint = '/check';

$lang = 'en-US';

$api_key = '9JMF2Y56';

$text = 'A quick brown fox jump over the lazzy dog';

//Usage # 2 is overriding using constructor
$grammarbot = new GrammarBot($base_uri, $endpoint, $api_key, $lang);

//call the api
$result = $grammarbot->check($text);

print_r($result);