<?php

namespace Statamic\Search;

use Statamic\Facades\Search;
use Statamic\Tags\OutputsItems;
use Statamic\Tags\Tags as BaseTags;

class Tags extends BaseTags
{
    use OutputsItems;

    protected static $handle = 'search';

    public function results()
    {
        $results = Search::index($this->get('index'))
            ->ensureExists()
            ->search(request($this->get('query', 'q')))
            ->withData($this->get('supplement_data', true))
            ->limit($this->get('limit'))
            ->offset($this->get('offset'))
            ->get();

        return $this->output($results);
    }
}