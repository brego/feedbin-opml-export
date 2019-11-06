<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use Countable;
use Iterator;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
abstract class Collection implements Iterator, Countable {
    protected $collection = [];

    public function current() {
        return current($this->collection);
    }

    public function key() {
        return key($this->collection);
    }

    public function next(): void {
        next($this->collection);
    }

    public function rewind(): void {
        reset($this->collection);
    }

    public function valid(): bool {
        return key($this->collection) !== null;
    }

    public function count() {
        return count($this->collection);
    }
}
