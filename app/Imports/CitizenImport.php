<?php

namespace App\Imports;

use App\Citizen;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CitizenImport implements ToModel, WithHeadingRow

{
    use Importable;
    // HeadingRowFormatter::default('none');
    public function model(array $row)
    {

        return new Citizen([

            'first_name'  => $row['الاسم الأول'],
            'email'  => $row['البريد'],
            'father_name' => $row['اسم الأب'],
            'last_name' => $row['اسم العائلة'],
            'grandfather_name' => $row['اسم الجد'],
            'id_number' => $row['رقم الهوية'],
            'governorate' => $row['المحافظة'],
            'city' => $row['المنطقة'],
            'street' => $row['العنوان'],
            'mobile' => $row['رقم التواصل (1)'],
            'mobile2' => $row['رقم التواصل (2)'],

        ]);
    }
}
