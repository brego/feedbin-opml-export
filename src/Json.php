<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use Brego\FeedbinOpmlExport\Exception\JsonException;

/**
 * This will become irrelevant with PHP 7.3, where you can call
 * `json_decode($json, false, JSON_THROW_ON_ERROR)`.
 *
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Json {
    public static function decode(string $json): array {
        $json = json_decode($json, false);

        if (JSON_ERROR_NONE !== json_last_error()) {
            throw new JsonException(json_last_error_msg());
        }

        return $json;
    }
}
