<?php
/**
 * Object for formatting data for an item found in YouTube search results from the API
 *
 * constants
 ** thumbnailSizes
 ** baseUrl - The beginning of the URL, which is used by all results
 ** urls    - Array containing the possible next portions of the URL, dependent on the type of result
 *
 * members
 ** data        - The data for the result, as returned from the YouTube API
 ** description - Short summary of the video
 ** id          - Identifier for the item
 ** thumbnails  - list of thumbnails for each size, including URL and dimensions for each
 ** title       - Name of the video, channel or playlist
 ** url         - URL of the video, channel or playlist
 *
 * methods
 ** "getters" - Get data for the relevant item,
 *** getId
 *** getType
 *** getTitle
 *** getDescription
 *** getThumbnail
 */
namespace App;

class YoutubeResult {
    const thumbnailSizes = ['default', 'medium', 'high'];
    const baseUrl = 'https://youtube.com/';
    const urls = [
        'channel'  => 'channel/',
        'playlist' => 'playlist?list=',
        'video'    => 'watch?v='
    ];

    protected $data;
    public $description;
    public $id;
    public $thumbnails;
    public $title;
    public $type;
    public $url;

    function __construct($data)
    {
        $this->data = $data;

        $this->description = $this->getDescription();
        $this->id          = $this->getId();
        $this->thumbnails  = $this->getThumbnails();
        $this->title       = $this->getTitle();
        $this->type        = $this->getType();
        $this->url         = $this->getUrl();
    }

    function getId()
    {
        return $this->data->id->{$this->getType().'Id'};
    }

    // Get the type of search result (video, channel or playlist)
    function getType()
    {
        // Remove the `youtube#` prefix.
        return substr($this->data->id->kind, strpos($this->data->id->kind, '#') + 1);
    }

    // Get the name of the video, channel or playlist
    function getTitle()
    {
        // Decode entities. The app will apply character encoding where necessary.
        return html_entity_decode($this->data->snippet->title, ENT_QUOTES, 'UTF-8');
    }

    // Get the short summary for the search result
    function getDescription()
    {
        return $this->data->snippet->description;
    }

    // Get the link to the video, channel or playlist
    function getUrl()
    {
        // The beginning of the URL depends on the type of result. (These beginnings are defined in the class' constants.)
        // The last part of the URL is the ID.
        $type = $this->getType();
        $urls = self::urls;

        if (isset($urls[$type])) {
            return self::baseUrl . $urls[$type] . $this->getId();
        } else {
            return null;
        }
    }

    // Get an object containing thumbnails for each size (default, medium, large).
    // Each object in the list is an object with a URL. Video results also have a width and height.
    function getThumbnails()
    {
        return $this->data->snippet->thumbnails;
    }

    // Render the thumbnail as HTML for a given size.
    function renderThumbnail($size = 'default')
    {
        // Check that the supplied size is valid. If not, use the default.
        $size = in_array($size, self::thumbnailSizes) ? $size : 'default';
        // Get the thumbnail for the size.
        $thumbnail = $this->getThumbnails()->{$size};

        // Render HTML.
        return View('youtube/thumbnail', compact('thumbnail'));
    }
}