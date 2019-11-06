<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport\Opml;

use Closure;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Document {
    private $root;
    private $head;
    private $body;

    public function __construct() {
        $this->root = new Element('opml');
        $this->head = new Element('head');
        $this->body = new Element('body');

        $this->getRoot()->addAttribute('version', '2.0');
    }

    public function getRoot(): Element {
        return $this->root;
    }

    public function getHead(): Element {
        return $this->head;
    }

    public function head(Closure $callback): self {
        $callback($this->getHead());

        return $this;
    }

    public function getBody(): Element {
        return $this->body;
    }

    public function body(Closure $callback): self {
        $callback($this->getBody());

        return $this;
    }

    public function flatten(): string {
        return sprintf(
            "%s\n%s",
            '<?xml version="1.0" encoding="UTF-8"?>',
            $this
                ->getRoot()
                ->addChild($this->getHead())
                ->addChild($this->getBody())
                ->flatten()
        );
    }

    public function __toString(): string {
        return $this->flatten();
    }
}
