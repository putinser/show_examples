<?php

namespace App\Http\Requests;

use App\Models\Admin\Chat\ChatFiles;
use App\Models\Admin\Chat\ChatVideo;

class ApiFileSmall
{
    public $id;
    public $uri;
    public $name;
    public $size;
    public $preview;

    /**
     * ApiVideo constructor.
     *
     * @param ChatVideo $chat_video
     */
    public function __construct(ChatFiles $chatFile)
    {
        $this->id = $chatFile->id;
        $this->uri = $chatFile->uri;
        $this->name = $chatFile->name;
        $this->size = $chatFile->size;
        $this->preview = $chatFile->preview_url;
    }
}
