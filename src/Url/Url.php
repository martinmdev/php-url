<?php

namespace Martinm\Url;

/**
 * Class Url
 */
class Url implements \JsonSerializable
{
    /** @var  string */
    protected $scheme;

    /** @var  string */
    protected $host;

    /** @var  string|int|float */
    protected $port;

    /** @var  string */
    protected $user;

    /** @var  string */
    protected $pass;

    /** @var  string */
    protected $path;

    /** @var  string */
    protected $query;

    /** @var  string */
    protected $fragment;

    /** @var  array */
    protected $queryParameters = [];

    /** @var  bool */
    protected $areQueryParametersChanged = false;

    /** @var  bool */
    protected $isChanged = false;

    /** @var  string the url as a string */
    protected $url = '';

    /**
     * Url constructor.
     *
     * Initialize the url with a url string
     *
     * @param string $url
     */
    public function __construct($url)
    {
        $this->setUrl($url);
    }

    /**
     * Get the scheme
     *
     * @return string
     */
    public function getScheme()
    {
        return $this->scheme;
    }

    /**
     * Set the scheme
     *
     * @param $scheme
     *
     * @return Url
     */
    public function setScheme($scheme)
    {
        return $this->updateComponent($this->scheme, $scheme);
    }

    /**
     * Get the host
     *
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set the host
     *
     * @param $host
     *
     * @return Url
     */
    public function setHost($host)
    {
        return $this->updateComponent($this->host, $host);
    }

    /**
     * Get the port
     *
     * @return float|int|string
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set the port
     *
     * @param $port
     *
     * @return Url
     */
    public function setPort($port)
    {
        return $this->updateComponent($this->port, $port);
    }

    /**
     * Get the user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set the user
     *
     * @param $user
     *
     * @return Url
     */
    public function setUser($user)
    {
        return $this->updateComponent($this->user, $user);
    }

    /**
     * Get the pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set the pass
     *
     * @param $pass
     *
     * @return Url
     */
    public function setPass($pass)
    {
        return $this->updateComponent($this->pass, $pass);
    }

    /**
     * Get the path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path
     *
     * @param $path
     *
     * @return Url
     */
    public function setPath($path)
    {
        return $this->updateComponent($this->path, $path);
    }

    /**
     * Get the query
     * Rebuild it if necessary
     *
     * @return string
     */
    public function getQuery()
    {
        if ($this->areQueryParametersChanged && !empty($this->queryParameters)) {
            $this->rebuildQuery();
        }

        return $this->query;
    }

    /**
     * Parse the query and set the query parameters
     *
     * @param $query
     *
     * @return Url
     */
    public function setQuery($query)
    {
        parse_str($query, $parameters);

        return $this->setQueryParameters($parameters);
    }

    /**
     * Rebuild the query
     */
    protected function rebuildQuery()
    {
        $this->query = $this->buildQuery($this->queryParameters);
        $this->areQueryParametersChanged = false;
    }

    /**
     * Get the fragment
     *
     * @return string
     */
    public function getFragment()
    {
        return $this->fragment;
    }

    /**
     * Set the fragment
     *
     * @param $fragment
     *
     * @return Url
     */
    public function setFragment($fragment)
    {
        return $this->updateComponent($this->fragment, $fragment);
    }

    /**
     * Update a url component and flag the url as changed
     *
     * @param $component
     * @param $newValue
     *
     * @return Url
     */
    protected function updateComponent(&$component, $newValue)
    {
        $component = $newValue;
        $this->isChanged = true;

        return $this;
    }

    /**
     * Parse the $url into parts and populate the components with their values
     *
     * @param $url
     *
     * @return Url
     */
    public function setUrl($url)
    {
        $parts = parse_url($url);
        $parts = is_array($parts) ? $parts : [];

        if (isset($parts['query'])) {
            $query = $parts['query'];
            unset($parts['query']);
        }

        foreach ($parts as $k => $v) {
            $this->$k = $v;
        }

        $this->isChanged = !empty($parts);

        if (!empty($query)) {
            $this->setQuery($query);
        }

        return $this;
    }

    /**
     * Reset the query parameters and set them to the new $parameters
     *
     * @param array $parameters
     *
     * @return Url
     */
    public function setQueryParameters(array $parameters)
    {
        $this->queryParameters = [];

        return $this->addQueryParameters($parameters);
    }

    /**
     * Add the query $parameters and flag the query parameters as changed.
     * This method does not overwrite existing parameters.
     *
     * @param array $parameters
     *
     * @return Url
     */
    public function addQueryParameters(array $parameters)
    {
        $this->queryParameters += $parameters;
        $this->areQueryParametersChanged = true;
        $this->isChanged = true;

        return $this;
    }

    /**
     * Merge query and $parameters.
     * Flag the query parameters as changed
     *
     * @param array $parameters
     *
     * @return Url
     */
    public function overwriteQueryParameters(array $parameters)
    {
        $this->queryParameters = array_merge($this->queryParameters, $parameters);
        $this->areQueryParametersChanged = true;
        $this->isChanged = true;

        return $this;
    }

    /**
     * Overwrite only existing parameters
     *
     * @param array $parameters
     *
     * @return Url
     */
    public function overwriteExistingQueryParameters(array $parameters)
    {
        return $this->overwriteQueryParameters(array_intersect_key($parameters, $this->queryParameters));
    }

    /**
     * Get the query parameters
     *
     * @return array
     */
    public function getQueryParameters()
    {
        return $this->queryParameters;
    }

    /**
     * Build query string from parameters
     *
     * @param $params
     *
     * @return string
     */
    public function buildQuery($params)
    {
        return http_build_query($params);
    }

    /**
     * Validate a string for a url
     *
     * @param string $urlWannabe
     *
     * @return bool
     */
    public static function isValidUrl($urlWannabe)
    {
        return filter_var($urlWannabe, FILTER_VALIDATE_URL) !== false;
    }

    /**
     * Assemble all url components into a url string and update $this->url
     * Validate the url
     * Flag the url as not changed
     */
    protected function assemble()
    {
        $parts = [];
        if (isset($this->scheme)) {
            $parts[] = $this->scheme;
            $parts[] = ':';
        }
        $parts[] = '//';
        if (isset($this->user)) {
            $parts[] = $this->user;
            $parts[] = ':';
        }
        if (isset($this->pass)) {
            $parts[] = $this->pass;
            $parts[] = '@';
        }
        if (isset($this->host)) {
            $parts[] = $this->host;
        }
        if (isset($this->port)) {
            $parts[] = ':';
            $parts[] = $this->port;
        }
        if (isset($this->path)) {
            $parts[] = $this->path;
        } else {
            $parts[] = '/';
        }
        $query = $this->getQuery();
        if (!empty($query)) {
            $parts[] = '?';
            $parts[] = $query;
        }
        if (isset($this->fragment)) {
            $parts[] = '#';
            $parts[] = $this->fragment;
        }

        $this->url = implode('', $parts);

        $this->isChanged = false;
    }

    /**
     * Get as string
     *
     * @return string
     */
    public function toString()
    {
        if ($this->isChanged) {
            $this->assemble();
        }

        return $this->url;
    }

    /**
     * Get as string magic method
     *
     * @return string
     */
    public function __toString()
    {
        return $this->toString();
    }

    /**
     * Return a protocol-relative url. Ex:
     * //example.com
     *
     * http: (or any other scheme) and : in the beginning are omitted.
     *
     * https://en.wikipedia.org/wiki/Wikipedia:Protocol-relative_URL
     *
     * @param $url
     *
     * @return mixed
     */
    public static function getProtocolRelativeUrl($url)
    {
        $scheme = parse_url($url, PHP_URL_SCHEME);
        if ($scheme) {
            $url = preg_replace('#^' . $scheme . ':#', '', $url);
        }

        return $url;
    }

    /**
     * Return the url as a string when json_encode()-ed
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return $this->toString();
    }

    /**
     * Get domain from url
     *
     * @param $url
     *
     * @return mixed
     */
    public static function getDomainFromUrl($url)
    {
        // Prepend scheme (http://) if missing, otherwise parse_url does not work
        if (strpos($url, "://") === false) {
            $url = "http://" . $url;
        }

        return parse_url($url, PHP_URL_HOST);
    }
}
