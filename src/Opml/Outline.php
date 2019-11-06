<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport\Opml;

use Brego\FeedbinOpmlExport\Category;
use Brego\FeedbinOpmlExport\Subscription;
use InvalidArgumentException;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Outline extends Element {
    /**
     * @param Subscription|Category $item
     */
    public static function from($item): self {
        if ($item instanceof Subscription) {
            return self::fromSubscription($item);
        }
        if ($item instanceof Category) {
            return self::fromCategory($item);
        }

        throw new InvalidArgumentException('Unknown type of item');
    }

    public static function fromSubscription(Subscription $subscription): self {
        return (new static('outline'))
            ->addAttribute('text', $subscription->getTitle())
            ->addAttribute('title', $subscription->getTitle())
            ->addAttribute('type', 'rss')
            ->addAttribute('xmlUrl', $subscription->getFeedUrl())
            ->addAttribute('htmlUrl', $subscription->getSiteUrl());
    }

    public static function fromCategory(Category $category): self {
        $outline = (new static('outline'))
            ->addAttribute('text', $category->getName())
            ->addAttribute('title', $category->getName());

        foreach ($category->getSubscriptions() as $subscription) {
            $outline->addChild(self::fromSubscription($subscription));
        }

        return $outline;
    }
}
