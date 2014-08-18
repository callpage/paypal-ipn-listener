<?php

namespace Mdb\PayPal\Ipn;

class Message
{
    /**
     * @var array
     */
    private $data;

    /**
     * @param array|string $data
     */
    public function __construct($data)
    {
        if (!is_array($data)) {
            $data = $this->extractDataFromRawPostDataString($data);
        }

        $this->data = $data;
    }

    /**
     * @param string $key
     *
     * @return string
     */
    public function get($key)
    {
        $value = '';

        if (isset($this->data[$key])) {
            $value = $this->data[$key];
        }

        return $value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $str = '';

        foreach ($this->data as $k => $v) {
            $str .= sprintf('%s=%s&', $k, urlencode($v));
        }

        return rtrim($str, '&');
    }

    /**
     * @param string $rawPostDataString
     *
     * @return array
     */
    private function extractDataFromRawPostDataString($rawPostDataString)
    {
        $data = array();
        $keyValuePairs = explode('&', $rawPostDataString);

        foreach ($keyValuePairs as $keyValuePair) {
            list($k, $v) = explode('=', $keyValuePair);

            $data[$k] = urldecode($v);
        }

        return $data;
    }
}
