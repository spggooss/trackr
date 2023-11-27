<?php

namespace App\Http\Controllers\Web\Packages\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;

class ImportCsvRequest extends FormRequest
{

    public function rules(){
        return [
            'csv_file' => 'required',
        ];
    }

    public function getFile(): ?UploadedFile
    {
        return $this->file('csv_file');
    }

}
