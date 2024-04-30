<?php

namespace App\Search;

use Elastic\Elasticsearch\Client as ElasticsearchClient;
// use Elasticsearch\Client;

class ElasticsearchObserver
{
    public function __construct(private ElasticsearchClient $elasticsearchClient)
    {
        // ...
    }

    public function saved($model)
    {
        $model->elasticSearchIndex($this->elasticsearchClient);
    }

    public function deleted($model)
    {
        $model->elasticSearchDelete($this->elasticsearchClient);
    }
}