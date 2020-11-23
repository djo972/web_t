<?php

namespace App\Services;

use Vimeo\Vimeo;

class VimeoVideo
{
    function getPreset(Vimeo $client)
    {
        $uri = '/me/presets';
        $res = $client->request($uri, array(), 'GET');
        $set = null;
        foreach ($res['body']['data'] as $preset) {
            if ($preset['name'] == 'playlist-ui') {
                $set = $preset;
                break;
            }
        }
        $set = (isset($set)) ? $set : $res['data'][0];
        return basename($set['uri']);

    }

    function setPreset(Vimeo $client, $video)
    {
        $uri = '/videos/' . $video . '/presets/' . $this->getPreset($client);
        $client->request($uri, array(), 'PUT');
    }

    function setDomain(Vimeo $client, $video)
    {
        $uri = '/videos/' . $video . '/privacy/domains/' . config('vimeo.domain');
        $client->request($uri, array(), 'PUT');
    }

    function upload(Vimeo $client, $name, $desc, $videoFile)
    {
        $uri = $client->upload($videoFile, array(
            "name" => $name,
            "description" => $desc,
            "privacy" => array(
                "embed" => "whitelist",
                "view" => "disable"
            )
        ));
        $res = $client->request($uri . '?fields=link');
        $video = basename($res['body']['link']);
        $this->setPreset($client, $video);
        $this->setDomain($client, $video);
        return $video;
    }

    function update(Vimeo $client, $name, $desc, $videoFile)
    {
        $client->request('/videos/' . $videoFile, array(
            'name' => $name,
            'description' => $desc,
        ), 'PATCH');
    }

    function delete(Vimeo $client, $videoFile)
    {
        $client->request('/videos/' . $videoFile, array(), 'DELETE');
    }
}