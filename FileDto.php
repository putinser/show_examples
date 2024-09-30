<?php

namespace App\Http\Requests;

use App\Interfaces\DTO\DtoInterface;
use Illuminate\Http\UploadedFile;

/**
 * Class FileDto
 *
 * @package App\Http\Requests
 */
class FileDto extends AbstractDto
{

    /* @var string */
    public $id;

    /* @var int */
    public $chunkNumber;

    /* @var int */
    public $chunkTotal;

    /* @var UploadedFile */
    public $file;

    /* @var bool */
    public $isVoice;


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected function rules(): array
    {
        return [
            'id' => 'required|uuid',
            'chunk_number' => 'required|integer',
            'chunk_total' => 'required|integer',
            'file' => 'required|file',
            'is_voice' => 'required|bool',
        ];
    }
}
