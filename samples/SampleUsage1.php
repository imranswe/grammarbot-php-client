<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$text = 'A quick brown fox jummp over the lazzy dog';

/*Usage # 1 is using all defaults */
$grammarbot = new GrammarBot();

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
