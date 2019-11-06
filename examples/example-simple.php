<?php declare(strict_types = 1);

require dirname(__FILE__) . '/../vendor/autoload.php';

use Brego\FeedbinOpmlExport\CurlFake;
use Brego\FeedbinOpmlExport\Feedbin;

/**
 * Your user and password for Feedbin.
 */
$user = 'your-feedbin@account.user';
$password = 'your-feedbin-password';

/**
 * CurlFake is a stub Used for testing, so we don't call the live API all of the time. It uses json
 * files found in `/json-examples/`.
 *
 * Use Brego\FeedbinOpmlExport\Curl to call the API.
 */
$curl = new CurlFake($user, $password);
$feedbin = new Feedbin($curl);

/**
 * This shortcut method fetches subscriptions, taggings, and convert those to an OPML document
 * containing subscriptions and categories. See example-full.php for more controll.
 */
$document = $feedbin->fetchAndConvertToOpml('RSS subscriptions for John Doe', 'johndoe@exemple.com');

echo $document;
