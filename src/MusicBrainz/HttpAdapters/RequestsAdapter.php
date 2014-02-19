<?php

namespace MusicBrainz\HttpAdapters;

use MusicBrainz\Exception;
use Requests;

/**
 * Requests HTTP Client Adapter
 */
class RequestsHttpAdapter extends AbstractHttpAdapter
{
    /**
     * Initializes the class.
     */
    public function __construct()
    {
    }

    /**
     * Perform an HTTP request on MusicBrainz
     *
     * @param  string  $path
     * @param  array   $params
     * @param  array   $options
     * @param  boolean $isAuthRequired
     *
     * @throws \MusicBrainz\Exception
     * @return array
     */
    public function call($path, array $params = array(), array $options = array(), $isAuthRequired = false)
    {
        if ($options['user-agent'] == '') {
            throw new Exception('You must set a valid User Agent before accessing the MusicBrainz API');
        }

        $url = self::URL . '/' . $path;
        $i   = 0;
        foreach ($params as $name => $value) {
            $url .= ($i++ == 0) ? '?' : '&';
            $url .= urlencode($name) . '=' . urlencode($value);
        }

        $headers = array(
            'Accept'     => 'application/json',
            'User-Agent' => $options['user-agent']
        );

        $requestOptions = array();
        if ($isAuthRequired) {
            if ($options['user'] != null && $options['password'] != null) {
                $requestOptions['auth'] = array($options['user'], $options['password']);
            } else {
                throw new Exception('Authentication is required');
            }
        }
        $request = Requests::get($url, $headers, $requestOptions);

        return json_decode($request->body);
    }
}