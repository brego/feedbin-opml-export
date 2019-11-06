<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport\Opml;

use Brego\FeedbinOpmlExport\Collection;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Elements extends Collection {
    public function add(Element $element): void {
        $this->collection[] = $element;
    }

    public function addElements(Elements $elements) {
        foreach ($elements as $element) {
            $this->add($element);
        }
    }

    public function current(): Element {
        return parent::current();
    }

    public function flatten(): string {
        $elements = [];

        foreach ($this as $element) {
            $elements[] = $element->flatten();
        }

        return implode('', $elements);
    }

}
