<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use Brego\FeedbinOpmlExport\Opml\Document;
use Brego\FeedbinOpmlExport\Opml\Element;
use Brego\FeedbinOpmlExport\Opml\Outlines;
use DateTime;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 * @link    Feedbin API <https://github.com/feedbin/feedbin-api>
 */
class Feedbin {
    public const URI = 'https://api.feedbin.com/v2/';
    public const SUBSCRIPTIONS = 'subscriptions.json';
    public const TAGGINGS = 'taggings.json';

    private $curl;

    public function __construct(Curl $curl) {
        $this->curl = $curl;
    }

    public function fetchSubscriptions(): Subscriptions {
        $subscriptions = $this->curl->get(self::URI . self::SUBSCRIPTIONS);
        $subscriptions = Json::decode($subscriptions);

        return Subscriptions::fromArray($subscriptions);
    }

    public function fetchTaggings(): Taggings {
        $data = $this->curl->get(self::URI . self::TAGGINGS);
        $data = Json::decode($data);

        return Taggings::fromArray($data);
    }

    public function fetchCategories(Subscriptions $subscriptions): Categories {
        $taggings = $this->fetchTaggings();

        return $this->makeCategories($subscriptions, $taggings);
    }

    public function makeCategories(
        Subscriptions $subscriptions,
        Taggings $taggings
    ): Categories {
        return Categories::fromSubscriptionsAndTaggings($subscriptions, $taggings);
    }

    public function fetchAndConvertToOpml(string $title, string $owner_email = ''): Document {
        $subscriptions = $this->fetchSubscriptions();
        $categories = $this->fetchCategories($subscriptions);

        return (new Document())
            ->head(
                function(Element $head) use ($title, $owner_email) {
                    $head
                        ->addAttribute('title', $title)
                        ->addAttribute('ownerEmail', $owner_email)
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
    }
}
