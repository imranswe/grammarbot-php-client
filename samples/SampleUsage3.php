<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$base_uri = 'http://api.grammarbot.io/v2';

$endpoint = '/check';

$lang = 'en-US';

$api_key = '9JMF2Y56';

$text = 'A quick brown fox jump over the lazzy dog';

//Usage # 3 is overriding using methods
$grammarbot = new GrammarBot();

//override default base_uri
$grammarbot->setBaseUri($base_uri);

//override default end point method
$grammarbot->setEndPoint($endpoint);

//override default Api Key
$grammarbot->setApiKey($api_key);

//override default language en-US
$grammarbot->setLanguage($lang);

//call the api
$json = $grammarbot->check($text);

$matches = $json->matches;

foreach($matches as $match){

	echo $match->message. "<br>";

	echo $match->offset. "<br>";

	echo $match->length. "<br>";

	echo $match->context->text. "<br>";

	echo $match->rule->id. "<br>";

	echo $match->rule->description. "<br>";

	echo $match->rule->issueType. "<br>";

	echo $match->rule->category->id. "<br>";

	echo $match->rule->category->name. "<br>";
}