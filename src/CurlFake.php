<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use InvalidArgumentException;

/**
 * Used for testing, so we don't call the live API all of the time.
 *
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class CurlFake extends Curl {
    public function get(string $uri): string {
        $direcotry = dirname(__FILE__) . '/../json-examples/';
        $file = $direcotry . str_replace(Feedbin::URI, '', $uri);

        if (is_file($file) === false) {
            throw new InvalidArgumentException(sprintf('No json example for uri "%s"', $uri));
        }

        return file_get_contents($file);
    }
}
