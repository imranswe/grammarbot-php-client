<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$text = 'A quick brown fox jummp over the lazzy dog';

/*Usage # 1 is using all defaults */
$grammarbot = new GrammarBot();

//call the api
$result = $grammarbot->check($text);

print_r($result);
