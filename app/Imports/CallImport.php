<?php

namespace App\Imports;

use App\Call;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

class CallImport implements ToModel, WithValidation, SkipsOnFailure
{
    public function rules(): array
    {
        return [
            '0' => 'required|string|max:200',
            '1' => 'required|numeric',
        ];
    }

    /**
     * @param array $row
     *
     * @return Model|null
     */
    public function model(array $row)
    {
        return new Call([
            'name' => $row[0],
            'phone' => $row[1],
        ]);
    }

    /**
     * @inheritDoc
     */
    public function onFailure(Failure ...$failures)
    {
        $bug = new MessageBag;
        foreach ($failures as $key => $failure) {
            $bug->add($key, $failure->errors()[$key]);
            session()->flash('errors', $bug);
        }

    }
}
