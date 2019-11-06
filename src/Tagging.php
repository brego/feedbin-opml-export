<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Tagging {
    private $name;
    private $feed_ids = [];

    public function __construct(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getFeedIds(): array {
        return $this->feed_ids;
    }

    public function addFeedId(int $feed_id): void {
        if (!in_array($feed_id, $this->feed_ids, true)) {
            $this->feed_ids[] = $feed_id;
        }
    }
}
