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

class CitizenNotbenfitExport implements ShouldAutoSize,WithEvents,FromView
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function view(): View
    {
        $q = $request["q"] ?? "";
        $accept = $request["accept"] ?? "";
        $project_id = $request["project_id"] ?? "";
        $usefull = $request["usefull"] ?? "";
        $keywords = preg_split("/[\s,]+/", $q);

        if (count($keywords) == 3) {
            $keywords[3] = "";
        }
        if (count($keywords) == 2) {
            $keywords[2] = "";
            $keywords[3] = "";
        }
        if (count($keywords) == 1) {
            $keywords[1] = "";
            $keywords[2] = "";
            $keywords[3] = "";
        }

        $project_ids = Account::find(auth()->user()->account->id)->projects()->pluck('projects.id');
        $citizen_ids = CitizenProjects::pluck('citizen_id');
        // dd($citizen_ids);
        $items = Citizen::whereNotIn('citizens.id', $citizen_ids)
            ->select(
                'citizens.id',
                'first_name',
                'father_name',
                'grandfather_name',
                'last_name',
                'id_number',
                'mobile',
                'mobile2',
                'governorate',
                'city',
                'street'
            )

            ->whereRaw("true");
        if ($q) {
            $items->whereRaw("(
            (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            or id_number like ? or governorate like ? or city like ?)"
                , ["%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$keywords[0]%", "%$keywords[1]%", "%$keywords[2]%", "%$keywords[3]%",
                    /**/
                    "%$q%", "%$q%", "%$q%", "%$q%",

                    "%$q%", "%$q%", "%$q%"]);
        }
        if ($usefull) {
            if ($usefull == 1) {
                $citizensids = CitizenProjects::pluck('citizen_id');
                //dd($citizensids);
                // $items->whereIn("id"
                //     , $citizensids);
                $items->whereIn("id"
                    , $citizensids);
            } else if ($usefull == 2) {
                $citizensids = CitizenProjects::pluck('citizen_id');
                // $items->whereNotIn("id"
                //     , $citizensids);
                $items->whereNotIn("id"
                    , $citizensids);
            }
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            $citizensids = Project::find($project_id)->citizen_projects->pluck('citizen_id');
            // $items->whereIn("id"
            //     , $citizensids);
            $items->whereIn("id"
                , $citizensids);
            $project_name = Project::find($project_id)->name;
        } else
            $project_name = "";


        if ($accept != "") {
            // $items->whereRaw("add_byself = ?", [$accept]);
            $items->whereRaw("add_byself = ?", [$accept]);
        }
        if (($project_id || $project_id == '0') && $project_id != '1') {
            if (in_array(1, $project_ids->toArray())) {
                // $items = $items->union($items2);
            }
        } else {
            // $items = $items->union($items2);
        }



        if(request('id_number')){
            $items->where("id_number", request('id_number'));
        }
        if(request('id')){
            $items->where("id", request('id'));
        }
        if(request('first_name')){
            $items->where("first_name", request('first_name'));
        }

        if(request('governorate')){
            $items->where("governorate", request('governorate'));
        }

        $items = $items->orderBy("citizens.id", 'desc')->get();
        return view('account.citizen.exportnotbenfit', [
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
