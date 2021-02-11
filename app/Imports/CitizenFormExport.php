<?php
namespace App\Imports;
use App\Account;
use App\Citizen;
use App\Form;

use App\Form_status;
use App\Form_type;
use App\Sent_type;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class CitizenFormExport implements ShouldAutoSize,WithEvents,FromView
{

    use Exportable;

    protected $id;

    public function __construct(int $id) {

        $this->id = $id;

    }

    public function view(): View
    {
        $evaluate = $request["evaluate"] ?? "";
        $q = $request["q"] ?? "";
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
        $item = Citizen::find($this->id);
        if ($item == NULL) {
            Session::flash("msg", "e:الرجاء التاكد من الرابط المطلوب");
            return redirect("/account/form");
        }
        $items = $item->forms()->whereIn('project_id', Account::find(auth()->user()->account->id)->projects()->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->pluck('categories.id'))->join('projects', 'projects.id', '=', 'forms.project_id')
            ->join('project_status', 'projects.active', '=', 'project_status.id')
            ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
            ->join('form_status', 'forms.status', '=', 'form_status.id')
            ->join('form_type', 'forms.type', '=', 'form_type.id')
            ->join('categories', 'categories.id', '=', 'forms.category_id')
            ->join('citizens', 'citizens.id', '=', 'forms.citizen_id')
            ->select('forms.id',
                'citizens.first_name', 'citizens.father_name', 'citizens.grandfather_name', 'citizens.last_name', 'citizens.id_number'
                , 'categories.name as nammes', 'forms.title',
                'projects.name as zammes', 'project_status.name as sammes',
                'forms.datee', 'form_status.name as fammes'
                , 'form_type.name as zzammes', 'sent_type.name as ozammes', 'forms.content')
            ->whereRaw("true");
        if ($q)
            $items->whereRaw("(
            (first_name like ? and father_name like ? and grandfather_name like ? and last_name like ?)
            or (first_name like ? and last_name like ? and grandfather_name like ? and father_name like ?)
            or (first_name like ? and grandfather_name like ? and last_name like ? and father_name like ?)
            or (father_name like ? and grandfather_name like ? and first_name like ? and last_name like ?)
            or (father_name like ? and last_name like ? and grandfather_name like ? and first_name like ?)
            or (grandfather_name like ? and last_name like ? and father_name like ? and first_name like ?)
            or first_name like ? or  father_name like? or grandfather_name like?  or  last_name like?

            or projects.name like ? or forms.title like ? or forms.id like ? or citizens.id_number like ?)"
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

                    "%$q%", "%$q%", "%$q%", "%$q%"]);
        if ($evaluate) {

            if ($evaluate == 1) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", ">=", "0");
            } elseif ($evaluate == 2) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", "=", "1");
            } elseif ($evaluate == 3) {
                $items->join('form_follows', 'forms.id', '=', 'form_follows.form_id')->groupBy('form_follows.form_id')
                    ->where("form_follows.solve", "=", "2");
            } elseif ($evaluate == 4) {


                $items->whereNotIn('forms.id', function ($query) {
                    $query->select('form_follows.form_id')
                        ->where("form_follows.solve", ">=", "1")
                        ->from('form_follows');

                });
            }
        }


        $items = $items->where(function ($query) {

        })->where(function ($query) {

            return $query->when(request('form_status'), function ($query) {

                return $query->where('status', request('form_status'));

            });

        })->where(function ($query) {

            return $query->when(request('type'), function ($query) {

                return $query->where('forms.type', request('type'));

            });

        })->where(function ($query) {

            return $query->when(request('id_number'), function ($query) {

                return $query->where('citizens.id_number', request('id_number'));

            });

        })->where(function ($query) {

            return $query->when(request('category_name') == "0", function ($query) {

                return $query->where('forms.project_id', '!=', 1);

            });

        })->where(function ($query) {

            return $query->when(request('category_name') == "1", function ($query) {

                return $query->where('forms.project_id', 1);

            });

        })->where(function ($query) {

            return $query->when(request('evaluate'), function ($query) {

                return $query->where('evaluate', request('evaluate'));

            });

        })->where(function ($query) {

            return $query->when(request('project_id'), function ($query) {

                return $query->where('project_id', request('project_id'));

            });

        })->where(function ($query) {

            return $query->when(request('sent_type'), function ($query) {

                return $query->where('sent_type', request('sent_type'));

            });
        })->where(function ($query) {

            return $query->when(request('category_id'), function ($query) {

                return $query->where('category_id', request('category_id'));

            });

        })->where(function ($query) {

            return $query->when(request('datee'), function ($query) {

                return $query->whereDate('forms.datee', request('datee'));

            });

        })->where(function ($query) {

            return $query->when(request('from_date'), function ($query) {

                return $query->where([['forms.datee', '>=', request('from_date')], ['forms.datee', '<=', request('to_date')]]);

            });

        })->where(function ($query) {

            return $query->when(request('to_date'), function ($query) {

                return $query->where([['forms.datee', '>=', request('from_date')], ['forms.datee', '<=', request('to_date')]]);

            });

        })->orderBy("forms.id", 'desc')->get();

        $items = Form::find($items->pluck('id'));

        return view('account.citizen.export2', [
            'items' => $items
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->setRightToLeft(true);
            },
        ];
    }

}
