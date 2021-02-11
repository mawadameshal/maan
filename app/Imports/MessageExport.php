<?php

namespace App\Imports;

use App\Account;
use App\Citizen;
use App\CitizenProjects;
use App\Project;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MessageExport implements ShouldAutoSize,WithEvents,FromView
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
     //
    public $the_collection;
    public function __construct($the_collection)
    {
        $this->the_collection = $the_collection;
    }

    public function view(): View
    {

        return view('account.citizen.export', [
            'items' => $this->the_collection
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

    public function collection(){
        return $this->the_collection;
    }
}
