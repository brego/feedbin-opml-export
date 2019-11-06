<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport\Opml;

use Brego\FeedbinOpmlExport\Categories;
use Brego\FeedbinOpmlExport\Subscriptions;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Outlines extends Elements {
    /**
     * @param Subscriptions|Categories $items
     */
    public static function from($items): self {
        $elements = new static();
        foreach ($items as $item) {
            $elements->add(Outline::from($item));
        }

        return $elements;
    }
}
