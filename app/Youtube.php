<?php
/*
 * Wrapper for calling the YouTube API
 *
 * Constants
 ** apiUrl   - base URL used for making API requests
 ** perPage  - number of results per page in the search results
 *
 * Members
 ** apiKey   - Key used for making API requests. Get this at developer.google.com
 *
 * Functions
 ** search   - Fetach a list of results from the API
 ** apiQuery - Send a query to the API
 */

namespace App;

class Youtube {
    const apiUrl = 'https://www.googleapis.com/youtube/v3/';
    const perPage = 10;

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('YOUTUBE_API_KEY', '');
    }

    /**
     * Make search requests on the API
     *
     * @param $params array list of parameters (token, keyword, type)
     * @return array List of results found and details about the search
     */
    public function search($params = [])
    {
        // Build the query to send to the YouTube API
        $query = [
            'maxResults' => self::perPage,
            'pageToken'  => isset($params->token)   ? $params->token   : '',
            'part'       => 'snippet',
            'q'          => isset($params->keyword) ? $params->keyword : '',
            'type'       => isset($params->type)    ? $params->type    : 'video, channel, playlist',
        ];

        $search = $this->apiQuery('search', $query);
        $results = [];

        if (!empty($search->items)) {
            foreach ($search->items as $item) {
                $results[] = new YoutubeResult($item);
            }
        }

        return compact('results', 'search');
    }

    /**
     * Send a request to the YouTube API
     *
     * @param $action string  the type of action to perform. See https://developers.google.com/youtube/v3/docs#resource-types
     * @param $query  array   list of parameters to send to the API
     *
     * @return object
     */
    public function apiQuery($action, $query = [])
    {
        $query['key'] = $this->apiKey;

        // Form the URL and its query string
        $url = self::apiUrl . $action . '?' . http_build_query($query);

        // Make a Curl request
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($ch);
        curl_close($ch);

        // Return the data from the request
        return json_decode($response);
    }
}