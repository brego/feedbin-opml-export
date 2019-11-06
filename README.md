# Feedbin to OPML export

Using [Feedbin API], fetch and convert your [Feedbin] subscriptions to an OPML file, which can be
published on your website.

This library is meant to periodically publish a list of your personal subscriptions - there is no
built in cache mechanism, but please implement that on your end. There's no reason to missuse the
API server ressources.

## Usage

Construct an object of `Brego\FeedbinOpmlExport\Curl` with your Feedbin credentials, pass it to 
`Brego\FeedbinOpmlExport\Feedbin`, and run `fetchAndConvertToOpml` to get an instance of 
`Brego\FeedbinOpmlExport\Opml\Document` which you can manipulate, save to disk as OPML or echo
directly.

The following examples are also found in the `examples` directory:

### Simple example

```php
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
```

### Full example

```php

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
```

## Links

 * [Feedbin]
 * [Feedbin API]

[Feedbin]: https://feedbin.com
[Feedbin API]: https://github.com/feedbin/feedbin-api
