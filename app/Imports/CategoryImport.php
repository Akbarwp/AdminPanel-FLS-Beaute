<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class CategoryImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Category([
            'nama_kategori'  => $row['nama_kategori'],
        ]);
    }

    public function rules(): array
    {
        return [
            '*.nama_kategori' => ['unique:categories,nama_kategori']
        ];
    }
}
