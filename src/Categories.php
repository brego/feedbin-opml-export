<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Categories extends Collection {
    public static function fromSubscriptionsAndTaggings(
        Subscriptions $subscriptions,
        Taggings $taggings
    ): self {
        $collection = new static();

        foreach ($taggings as $tagging) {
            $collection->add(
                new Category(
                    $tagging->getName(),
                    Subscriptions::fromIds($tagging->getFeedIds(), $subscriptions)
                )
            );
        }

        return $collection;
    }

    public function add(Category $category): void {
        $this->collection[$category->getName()] = $category;
    }

    public function current(): Category {
        return parent::current();
    }
}
