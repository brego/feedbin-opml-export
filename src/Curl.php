<?php declare(strict_types = 1);

namespace Brego\FeedbinOpmlExport;

use Brego\FeedbinOpmlExport\Exception\CurlException;

/**
 * @author  Kamil "Brego" Dzieliński <contact@brego.dev>
 * @package <https://github.com/brego/feedbin-opml-export>
 * @license MIT <https://opensource.org/licenses/MIT>
 */
class Curl {
    private $user = '';
    private $password = '';

    public function __construct(
        string $user,
        string $password
    ) {
        $this->user = $user;
        $this->password = $password;
    }

    /**
     * @todo Add support for If-Modified-Since, returns `304 Not Modified` if no news
     *       ```php
     *       curl_setopt($handler, CURLOPT_HTTPHEADER, [
     *          'If-Modified-Since: ' . $modified->format(DateTime::RFC822)
     *       ]);
     *       ```
     */
    public function get(string $uri): string {
        $handler = curl_init($uri);

        curl_setopt($handler, CURLOPT_USERPWD, sprintf('%s:%s', $this->user, $this->password));
        curl_setopt($handler, CURLOPT_RETURNTRANSFER, true);

        $content = curl_exec($handler);
        $code = curl_getinfo($handler, CURLINFO_HTTP_CODE);

        if ($code !== 200) {
            throw new CurlException(sprintf('%s %s', $code, $content));
        }

        if ($content === false) {
            throw new CurlException(curl_error($handler));
        }

        curl_close($handler);

        return $content;
    }
}
