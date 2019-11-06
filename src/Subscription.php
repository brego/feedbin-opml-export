<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use DateTime;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Subscription {
    private $created_at;
    private $feed_id;
    private $title;
    private $feed_url;
    private $site_url;

    public function __construct(
        DateTime $created_at,
        int $feed_id,
        string $title,
        string $feed_url,
        string $site_url
    ) {
        $this->created_at = $created_at;
        $this->feed_id = $feed_id;
        $this->title = $title;
        $this->feed_url = $feed_url;
        $this->site_url = $site_url;
    }

    public function getFeedId(): int {
        return $this->feed_id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getFeedUrl(): string {
        return $this->feed_url;
    }

    public function getSiteUrl(): string {
        return $this->site_url;
    }
}
