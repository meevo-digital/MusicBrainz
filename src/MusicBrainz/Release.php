<?php

namespace MusicBrainz;

/**
 * Represents a release object.
 *
 */
class Release
{
    public $id;
    public $title;
    public $status;
    public $quality;
    public $language;
    public $script;
    public $date;
    public $country;
    public $barcode;
    public $artists = array();

    public function __construct(array $release)
    {

        $this->id        = isset($release['id']) ? (string) $release['id'] : '';
        $this->title     = isset($release['title']) ? (string) $release['title'] : '';
        $this->status    = isset($release['status']) ? (string) $release['status'] : '';
        $this->quality   = isset($release['quality']) ? (string) $release['quality'] : '';
        $this->language  = isset($release['text-representation']['language']) ? (string) $release['text-representation']['language'] : '';
        $this->script    = isset($release['text-representation']['script']) ? (string) $release['text-representation']['script'] : '';
        $this->date      = isset($release['date']) ? (string) $release['date'] : '';
        $this->country   = isset($release['country']) ? (string) $release['country'] : '';
        $this->barcode   = isset($release['barcode']) ? (string) $release['barcode'] : '';

    }

    /**
     * Get included releases from the XML of another entity
     *
     * @static
     * @param \SimpleXMLElement $result
     * @param $entity string
     * @return array
     */
    public static function getIncluded(\SimpleXMLElement $result, $entity)
    {
        $releases = array();

        if (isset($result->$entity->{'release-list'})) {
            foreach ($result->$entity->{'release-list'}->release as $release) {
                $releases[] = new self($release);
            }
        }

        return $releases;
    }
}
