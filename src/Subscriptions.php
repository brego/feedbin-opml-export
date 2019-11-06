<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use DateTime;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Subscriptions extends Collection {
    public static function fromArray(array $items): self {
        $collection = new static();

        foreach ($items as $item) {
            $collection->add(
                new Subscription(
                    new DateTime($item->created_at),
                    (int) $item->feed_id,
                    (string) $item->title,
                    (string) $item->feed_url,
                    (string) $item->site_url
                )
            );
        }

        return $collection;
    }

    public static function fromIds(array $ids, Subscriptions $subscriptions): self {
        $collection = new static();

        foreach ($ids as $id) {
            $collection->add($subscriptions->get($id));
        }

        return $collection;
    }

    public function add(Subscription $feed): void {
        $this->collection[$feed->getFeedId()] = $feed;
    }

    public function get(int $feed_id): ?Subscription {
        return $this->collection[$feed_id] ?? null;
    }

    public function current(): Subscription {
        return parent::current();
    }
}
