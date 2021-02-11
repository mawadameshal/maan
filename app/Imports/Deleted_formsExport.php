<?php
namespace App\Imports;
use App\Form;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
class Deleted_formsExport implements FromCollection,WithHeadings
{
    public $the_collection;
    public function __construct($the_collection) {
        $this->the_collection = $the_collection;
    }
    public function headings(): array
    {
        return [
            'الرقم المرجعي',
            'الإسم الأول',
            'إسم الأب',
            'إسم الجد',
            'إسم العائلة',
            'رقم الهوية',
            'المحافظة',
            'المنطقة',
            'العنوان',
            'رقم التواصل (1)',

        ];
    }
    public function collection(){
        return $this->the_collection;
    }
}
