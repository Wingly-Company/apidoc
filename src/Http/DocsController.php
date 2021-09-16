<?php

namespace Wingly\ApiDoc\Http;

use Wingly\ApiDoc\Documentation;

class DocsController
{
    protected $docs;

    public function __construct(Documentation $docs)
    {
        $this->docs = $docs;
    }

    public function __invoke(string $page)
    {
        $content = $this->docs->get($page);

        if (is_null($content)) {
            abort(404);
        }

        return view('apidoc::docs', [
            'title' => $this->docs->getTitle(),
            'index' => $this->docs->getIndex(),
            'content' => $content,
        ]);
    }
}
