<?php

namespace App\Imports;

use App\Sms;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Http\Request;

class MessageImport implements ToModel, WithHeadingRow

{
    use Importable;

    protected $message_type_id;

    public function __construct(int $message_type_id) {
        if (is_null($message_type_id)){
            $this->message_type_id = 0;
        }else{
            $this->message_type_id = $message_type_id;
        }
    }

    public function model(array $row)
    {

        return new Sms([
            'name'  => $row['الاسم'],
            'message_text' => $row['نص الرسالة النصية'],
            'mobile' => $row['رقم التواصل'],
            'message_type_id' => $this->message_type_id,
            'count_message' => strlen($row['نص الرسالة النصية']),

        ]);
    }
}
