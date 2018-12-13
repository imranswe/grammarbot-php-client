# PHP HTTP Client for GrammarBot API

This is a HTTP Client wrapper written in PHP to utlize Grammarbot.io API. It is simple and straightforward. It can be installed using composer and manually.

## Installation

### Using Composer

Run below commands one by one in your project directory

```
git clone https://github.com/imranswe/grammarbot-php-client.git

composer install
```

### OR RUN only

```
composer require grammarbot/grammarbot-php-client:dev-master
```
### Manual installation

Download the repository code and directly require the GrammarBot.php file in your code

```
<?php
require_once dirname(__FILE__). '/src/GrammarBot/GrammarBot.php';

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

```
## First Usage

This example is using all defaults

```
<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$text = 'A quick brown fox jummp over the lazzy dog';

/*Usage # 1 is using all defaults */
$grammarbot = new GrammarBot();

//call the api
$result = $grammarbot->check($text);

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

```

## Second Usage

This example is overriding the defaults

```
<?php
require_once dirname(dirname(__FILE__)). '/vendor/autoload.php';

use GrammarBot\GrammarBot;

$base_uri = 'http://api.grammarbot.io/v2';

$endpoint = '/check';

$lang = 'en-US';

$api_key = 'yourOwnAPIKEY';

$text = 'A quick brown fox jump over the lazzy dog';

//Usage # 2 is overriding using constructor
$grammarbot = new GrammarBot($base_uri, $endpoint, $api_key, $lang);

//call the api
$result = $grammarbot->check($text);

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

```
