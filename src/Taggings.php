<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Taggings extends Collection {
    public static function fromArray(array $items): self {
        $collection = new static();

        foreach ($items as $item) {
            $collection->add(
                (string) $item->name,
                (int) $item->feed_id
            );
        }

        return $collection;
    }

    public function add(string $name, int $feed_id): void {
        $tagging = $this->get($name);

        if (is_null($tagging)) {
            $this->collection[$name] = new Tagging($name);
            $tagging = $this->get($name);
        }

        $tagging->addFeedId($feed_id);
    }

    public function get(string $tagging_name): ?Tagging {
        return $this->collection[$tagging_name] ?? null;
    }

    public function current(): Tagging {
        return parent::current();
    }
}
