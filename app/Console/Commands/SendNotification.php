<?php

namespace App\Console\Commands;

use App\Account;
use App\Form;
use App\Http\Controllers\Account\NotificationController;
use App\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendNotification extends Command
{
    protected $signature = 'send:notification';
    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $forms = Form::all();
        foreach ($forms as $form){
            $form_status = $form->status ;
            $form_data = $form->created_at ;
//            $daysToAdd = 2;
            $check_holiday  =  $form->created_at->addDay(1);
            $day = date("D", strtotime($check_holiday));
            if($day == 'Friday'){
                $daysToAdd   = 9;
            }elseif ($day == 'saturday'){
                $daysToAdd   = 8;
            }else{
                $daysToAdd   = 7;
            }

            if ( $form->response_type == 1 ){
                $daysToAdd += 2 ;
            }



            $date = $form->created_at->addDays($daysToAdd);
            if(Carbon::now() >= $date and $form_status == 1){
                if ($form->project->account_projects->first() && $form->category->circle_categories->first()) {
                    $accouts_ids_in_circle = Account::WhereIn('circle_id', $form->category->circle_categories->where('to_notify', 1)
                        ->pluck('circle_id')->toArray())->pluck('id')->toArray();
                    $accouts_ids_in_project = $form->project->account_projects->where('to_notify', 1)
                        ->pluck('account_id')->toArray();
                    $accouts_ids = array_merge($accouts_ids_in_circle, $accouts_ids_in_project);

                    $users_ids = Account::find($accouts_ids)->pluck('user_id');
                    for ($i = 0; $i < count($users_ids); $i++) {
//                        if (User::find($users_ids[$i])->account->links->contains(\App\Link::where('title', '=', 'الإشعارات')->first()->id)) {
                        if (check_permission_with_user_id('الإشعارات', $users_ids[$i])) {
                            NotificationController::insert(['user_id' => $users_ids[$i], 'type' => 'مواطن', 'title' => 'هناك نموذج لم يتم المعالجة', 'link' => "/citizen/form/show/" . Form::find($form->id)->citizen->id_number . "/$form->id"]);
                        }
//                        }
                    }
                }
            }
        }
    }
}
