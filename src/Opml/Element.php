<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport\Opml;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Element {
    private $name;
    private $content;
    private $attributes;
    private $children;

    public function __construct(
        string $name,
        string $content = '',
        array $attributes = [],
        ?Elements $children = null
    ) {
        $this->name = trim($name);
        $this->content = trim($content);
        $this->attributes = $attributes;
        $this->children = $children ?? new Elements();
    }

    public function getName(): string {
        return $this->name;
    }

    public function getAttributes(): array {
        return $this->attributes;
    }

    public function addAttribute(string $name, string $value): self {
        $this->attributes[$name] = trim(htmlspecialchars($value));

        return $this;
    }

    public function hasAttributes(): bool {
        return count($this->getAttributes()) > 0;
    }

    public function hasNoAttributes(): bool {
        return $this->hasAttributes() === false;
    }

    public function getContent(): string {
        return $this->content;
    }

    public function hasContent(): bool {
        return $this->getContent() !== '';
    }

    public function hasNoContent(): bool {
        return $this->hasContent() === false;
    }

    public function getChildren(): Elements {
        return $this->children;
    }

    public function addChild(Element $element): self {
        $this->getChildren()->add($element);

        return $this;
    }

    public function addChildren(Elements $children): self {
        $this->getChildren()->addElements($children);

        return $this;
    }

    public function hasChildren(): bool {
        return count($this->getChildren()) > 0;
    }

    public function hasNoChildren(): bool {
        return $this->hasChildren() === false;
    }

    public function flattenAttributes(): string {
        if ($this->hasNoAttributes()) {
            return '';
        }
        $attributes = [];
        foreach ($this->getAttributes() as $key => $value) {
            $attributes[] = sprintf('%s="%s"', $key, $value);
        }

        return ' ' . implode(' ', $attributes);
    }

    public function flatten(): string {
        if ($this->hasNoChildren() && $this->hasNoContent()) {
            return $this->flatEmptyElement();
        }

        if ($this->hasNoChildren() && $this->hasContent()) {
            return $this->flatElementWithContent();
        }

        return $this->flatElementWithChildren();
    }

    private function flatEmptyElement(): string {
        return sprintf(
            "<%s%s/>\n",
            $this->getName(),
            $this->flattenAttributes()
        );
    }

    private function flatElementWithContent(): string {
        return sprintf(
            "<%s%s>%s</%s>\n",
            $this->getName(),
            $this->flattenAttributes(),
            $this->getContent(),
            $this->getName()
        );
    }

    private function flatElementWithChildren(): string {
        return sprintf(
            "<%s%s>%s\n%s</%s>\n",
            $this->getName(),
            $this->flattenAttributes(),
            $this->getContent(),
            $this->getChildren()->flatten(),
            $this->getName()
        );
    }
}
