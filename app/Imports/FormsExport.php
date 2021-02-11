<?php
namespace App\Imports;
use App\Account;
use App\Form;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;

use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class FormsExport implements ShouldAutoSize,WithEvents,FromView
{
//    public $the_collection;
//    public function __construct($the_collection) {
//        $this->the_collection = $the_collection;
//    }

    public function view(): View
    {
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

        $items = Form::where('forms.deleted_at', null)->whereIn('project_id', Account::find(auth()->user()->account->id)
            ->projects()->with('account_projects')->pluck('projects.id'))
            ->whereIn('category_id', Account::find(auth()->user()->account->id)->circle->category()
                ->with('circle_categories')->pluck('categories.id'))
                ->join('projects', 'projects.id', '=', 'forms.project_id')
                ->join('accounts', 'accounts.id', '=', 'forms.account_id')
                ->join('project_status', 'projects.active', '=', 'project_status.id')
                ->join('sent_type', 'forms.sent_type', '=', 'sent_type.id')
                ->join('form_status', 'forms.status', '=', 'form_status.id')
                ->join('form_type', 'forms.type', '=', 'form_type.id')
                ->join('categories', 'categories.id', '=', 'forms.category_id')
                ->join('citizens', 'citizens.id', '=', 'forms.citizen_id')
                ->leftjoin('form_responses', 'form_responses.form_id', '=', 'forms.id')
            ->select('forms.id',
                'forms.project_id',
                'citizens.first_name',
                'citizens.father_name',
                'citizens.grandfather_name',
                'citizens.last_name',
                'citizens.id_number',
                'citizens.governorate',
                'citizens.city',
                'citizens.street',
                'citizens.mobile',
                'citizens.mobile2',
                'projects.name as binfit',
                'projects.name as zammes',
                'projects.end_date  as project_status',
                'sent_type.name  as senmmes',
                'forms.account_id',
                'accounts.full_name as employee_name',
                'forms.datee',
                'forms.evaluate',
                'forms.created_at',
                'form_type.name  as ammes',
                'categories.name as nammes',
                'forms.title',
                'forms.content',
                'form_status.id as form_status_ttt',
                'form_status.name',
                'forms.response_type',
                'forms.required_respond',
                'form_status.id as replay_status',
                'form_responses.datee as form_responses_datee',
                'form_responses.response as response'
            )

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


        $items = $items->where(function($query){

            return $query->when( request('read') , function($query){

                return $query->where('read' , request('read'));

            });

        })->where(function($query){

            return $query->when( request('status') , function($query){

                return $query->where('status' , request('status'));

            });


        })->where(function($query){

            return $query->when( request('type') , function($query){

                return $query->where('forms.type' , request('type'));

            });



        })->where(function($query){

            return $query->when( request('id') , function($query){

                return $query->where('forms.id' , request('id'));

            });




        })->where(function($query){

            return $query->when( request('id_number') , function($query){

                return $query->where('citizens.id_number' , request('id_number'));

            });




        })->where(function($query){

            return $query->when( request('citizen_id') , function($query){

                return $query->where('citizens.first_name' , 'like' ,   request('citizen_id'));

            });



        })->where(function($query){

            return $query->when( request('category_name') == "0" , function($query){

                return $query->where(  'forms.project_id' , '!=', 1);

            });

        })->where(function($query){

            return $query->when( request('category_name') == "1" , function($query){

                return $query->where(  'forms.project_id' , 1);

            });




        })->where(function($query){

            return $query->when( request('evaluate') , function($query){

                return $query->where('evaluate' , request('evaluate'));

            });






        })->where(function($query){

            return $query->when( request('project_id') , function($query){

                return $query->where('project_id' , request('project_id'));

            });

        })->where(function($query){

            return $query->when( request('sent_type') , function($query){

                return $query->where('sent_type' , request('sent_type'));

            });
        })->where(function($query){

            return $query->when( request('category_id') , function($query){

                return $query->where('category_id' , request('category_id'));

            });

        })->where(function($query){

            return $query->when( request('datee') , function($query){

                return $query->whereDate('forms.datee' , request('datee'));

            });

        })->where(function($query){

            return $query->when( request('from_date') , function($query){

                return $query->where([['forms.datee' ,'>=', request('from_date')] , ['forms.datee' ,'<=', request('to_date')]]);

            });

        })->where(function($query){

            return $query->when( request('to_date') , function($query){

                return $query->where([['forms.datee' ,'>=', request('from_date')] , ['forms.datee' ,'<=', request('to_date')]]);

            });

        })->orderBy("forms.id", 'desc')->get();

        foreach($items as $item) {

            if ($item->binfit == 'غير مستفيد') {
                $item->binfit = "غير مستفيد";
            } else {
                $item->binfit = " مستفيد";

            }

            if ($item->project_status < now()) {
                $item->project_status = "منتهي";
            } else {
                $item->project_status = "مستمر";
            }

            if ($item->account_id == null) {
                $item->account_id = "المواطن نفسه";
            } else {
                $item->account_id = "أحد موظفي المركز";
            }

            if ($item->response_type == 1) {
                $item->response_type = "تتطلب اجراءات مطولة للرد";
            } else {
                $item->response_type = "يمكن الرد عليها مباشرة";
            }

            if ($item->replay_status == 1) {
                $item->replay_status = "قيد الدراسة";
            } elseif ($item->replay_status == 2) {
                $item->replay_status = "تم الرد";
            } else {
                $item->replay_status = "";

            }

            if ($item->form_status_ttt == 1) {
                $item->form_status_ttt = " قيد التبليغ ";
            } elseif ($item->form_status_ttt == 2) {
                $item->form_status_ttt = "تم التبليغ";
            } else{
                $item->form_status_ttt = "لم يتم التبليغ";
           }

            if($item->evaluate){
                if($item->evaluate == 1){
                    $item->evaluate = "راضي بشكل كبير";
                }elseif($item->evaluate==2){
                    $item->evaluate = "راضي بشكل متوسط";

                }elseif($item->evaluate == 3){
                    $item->evaluate = "راضي بشكل ضعيف";
                }else{
                    $item->evaluate = "غير راضي عن الرد";
                }
            }else{
                $item->evaluate = "لم يتم الرد";
            }


        }

        return view('account.form.export', [
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



//    public function headings(): array
//    {
//        return [
//            'الرقم المرجعي',
//            'الإسم الأول',
//            'إسم الأب',
//            'إسم الجد',
//            'إسم العائلة',
//            'رقم الهوية',
//            'المحافظة',
//            'المنطقة',
//            'العنوان',
//            'رقم التواصل (1)',
//            'رقم التواصل (2)',
//            'فئة مقدم الاقتراح /الشكوى',
//            'اسم المشروع',
//            'حالة المشروع',
//            'قناة الاستقبال',
//            'اسم مسجل الاقتراح/الشكوى',
//            'اسم الموظف',
//            'تاريخ تقديم الاقتراح/الشكوى',
//            'تاريخ تسجيل الاقتراح /الشكوى',
//            'التصنيف',
//            'فئة الاقتراح/الشكوى',
//            'موضوع الاقتراح/الشكوى',
//            'محتوى الاقتراح/الشكوى',
//            'حالة الشكوى /الاقتراح',
//            'التصنيف بناءً على الاجراءات المطلوبة',
//            'طبيعة الاجراءات المطولة المطلوبة للرد',
//            'حاله الرد'
//        ];
//
//
//    }

//    public function collection(){
//        return $this->the_collection;
//    }
}
