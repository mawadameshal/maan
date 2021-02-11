<?php

namespace App\Imports;

use App\Account;
use App\Form;
use App\Project;
use App\Project_status;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class ProjectExport implements  ShouldAutoSize,WithEvents,FromView
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
//    public $the_collection;
//    public function __construct($the_collection)
//    {
//        //dd(Project::all());
//        $this->the_collection = $the_collection;
//    }
//    public function headings(): array
//    {
//        return [
//            '#',
//            'رمز المشروع',
//            'اسم المشروع','منسق المشروع','قسم المتابعة','مدير البرنامج','حالة المشروع','تاريخ بداية المشروع','تاريخ نهاية المشروع'
//        ];
//    }
//    public function collection()
//    {
//        return $this->the_collection;
//    }

    public function view(): View
    {

        Project::where('end_date','<=',Carbon::now())->update(['active' => '2']);

        $q = $request["q"] ?? "";
        $start_date = $request["start_date"] ?? "";
        $end_date = $request["end_date"] ?? "";
        $in_date = $request["in_date"] ?? "";
        $active = $request["active"] ?? "";
        $items = Account::find(auth()->user()->account->id)->projects()->join('project_status', 'projects.active', '=', 'project_status.id')
            ->select('projects.id',
                'projects.code',
                'projects.name',
                'projects.coordinator',//منسق المشروع
                'projects.supervisor', //سابقا المشرف , الان قسم المتابعة
                'projects.manager',   // مدير البرنامج
                'project_status.name as names',
                'projects.start_date', 'projects.end_date')
            ->whereRaw("true");
        if ($q)
            $items->whereRaw("(projects.name like ? or code like ? or manager like ? or supervisor like ? or coordinator like ?)"
                , ["%$q%", "%$q%", "%$q%", "%$q%", "%$q%"]);
        if ($active != "")
            $items->whereRaw("active = ?", [$active]);

        if (($end_date) && ($start_date)) {
            $items = $items->whereRaw("end_date <= ? and start_date >= ?", [$end_date, $start_date]);
        } else {
            if ($start_date)
                $items = $items->whereRaw("start_date = ?", [$start_date]);

            if ($end_date)
                $items = $items->whereRaw("end_date = ?", [$end_date]);
        }
        if ($in_date)
            $items = $items->whereRaw("end_date >= ? and start_date <= ?", [$in_date, $in_date]);


        $items = $items->where(function($query){


        })->where(function($query){

            return $query->when( request('active') , function($query){

                return $query->where('active' , request('active'));

            });

        })->where(function($query){

            return $query->when( request('project_name') , function($query){

                return $query->where('projects.name' , request('project_name'));

            });

        })->where(function($query){

            return $query->when( request('code') , function($query){

                return $query->where('projects.code' , request('code'));

            });

        })->where(function($query){

            return $query->when( request('manager') , function($query){

                return $query->where('projects.manager' , request('manager'));

            });



        })->where(function($query){

            return $query->when( request('coordinator') , function($query){

                return $query->where('projects.coordinator' , request('coordinator'));

            });

        })->where(function($query){

            return $query->when( request('support') , function($query){

                return $query->where('projects.support' , request('support'));

            });



        })->where(function($query){

            return $query->when( request('start_date') , function($query){

                return $query->whereDate('projects.start_date' , request('start_date'));

            });
        })->where(function($query){

            return $query->when( request('end_date') , function($query){

                return $query->whereDate('projects.end_date' , request('end_date'));

            });

        })->get();

        $items = Project::whereIn('id', $items->pluck('id'))->orderBy("projects.id", 'desc')->get();
        return view('account.project.export', [
            'items' => $items
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

}
