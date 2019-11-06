<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Category {
    private $name;
    private $subscriptions;

    public function __construct(string $name, Subscriptions $subscriptions) {
        $this->name = $name;
        $this->subscriptions = $subscriptions;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getSubscriptions(): Subscriptions {
        return $this->subscriptions;
    }
}
