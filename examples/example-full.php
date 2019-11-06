<?php declare(strict_types = 1);

error_reporting(-1);

require dirname(__FILE__) . '/../vendor/autoload.php';

use Brego\FeedbinOpmlExport\CurlFake;
use Brego\FeedbinOpmlExport\Feedbin;
use Brego\FeedbinOpmlExport\Opml\Document;
use Brego\FeedbinOpmlExport\Opml\Element;
use Brego\FeedbinOpmlExport\Opml\Outlines;

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
 * The Feedbin class provides interfaces to fetch Subscriptions and Taggings, and make categories
 * out of those. This is usefull if you need to manipulate those in any way before converting to
 * OPML.
 */
$subscriptions = $feedbin->fetchSubscriptions();
$taggings = $feedbin->fetchTaggings();
$categories = $feedbin->makeCategories($subscriptions, $taggings);

$document = (new Document())
    ->head(
        function(Element $head) {
            $head
                ->addAttribute('title', 'RSS subscriptions for John Doe')
                ->addAttribute('ownerEmail', 'johndoe@exemple.com')
                ->addAttribute('dateUpdated', (new DateTime())->format(DateTime::RFC822));
        }
    )
    ->body(
        function(Element $body) use ($subscriptions, $categories) {
            $body
                ->addChildren(Outlines::from($subscriptions))
                ->addChildren(Outlines::from($categories));
        }
    );

/**
 * `flatten()` shown here can be useful if you want to save the OPML document to a file.
 */
echo $document->flatten();
