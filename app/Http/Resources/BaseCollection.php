<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class BaseCollection extends ResourceCollection {
    public function toArray($request) {
        return [
            'data' => $this->collection,
        ];
    }

    public function withResponse($request, $response) {
        $data = $response->getData(true);

        if (isset($data['meta'])) {
            $data['meta']['count'] = $this->collection->count();

            if (isset($data['meta']['links'])) {
                $data['meta']['links'] = array_map(function ($row) {
                    $page = null;

                    if (!empty($row['url'])) {
                        $parsedUrl = parse_url($row['url']);
                        $queryParams = [];

                        if (isset($parsedUrl['query'])) {
                            parse_str($parsedUrl['query'], $queryParams);
                        }

                        if (isset($queryParams['page'])) {
                            $page = $queryParams['page'];
                        }
                    }

                    $row['page'] = $page;

                    unset($row['url']);

                    return $row;
                }, $data['meta']['links']);

            }
        }

        unset($data['links'], $data['meta']['path']);

        $response->setData($data);

    }
}
