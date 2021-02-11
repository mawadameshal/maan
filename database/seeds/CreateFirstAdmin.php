<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Company;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

class CreateFirstAdmin extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */


    public function run()
    {

        //الاعدادات العامة
        DB::table('company')->insertGetId([
            'title' => 'مركز العمل التنموي معاً',
            'welcom_word' => 'مرحبا بك',
            'welcom_clouse' => 'معا لتقديم الخدمة على افضل وجه , لا تتردد في تقديم طلب بكل ما تحتاج',
            'add_compline_clouse' => '. هذا النص هو مثال لنص يمكن ان يستبدل بنفس المساحة , لقد تم توليد هذا النص من مولد النص العربي , حيث يمكنك ان تولد مثل هذا النص',
            'add_propusel_clouse' => '. هذا النص هو مثال لنص يمكن ان يستبدل بنفس المساحة , لقد تم توليد هذا النص من مولد النص العربي , حيث يمكنك ان تولد مثل هذا النص',
            'add_thanks_clouse' => '. هذا النص هو مثال لنص يمكن ان يستبدل بنفس المساحة , لقد تم توليد هذا النص من مولد النص العربي , حيث يمكنك ان تولد مثل هذا النص',
            'follw_compline_clouse' => '. هذا النص هو مثال لنص يمكن ان يستبدل بنفس المساحة , لقد تم توليد هذا النص من مولد النص العربي , حيث يمكنك ان تولد مثل هذا النص',
            'how_we' => 'نحن عبارة عن شركة تقوم بتقديم مجموعة من الخدمات الي المجتمع وايضا نقوم بمساعدة المستخدم من تقديم مقترحات خاصة به من خلال تقديم طلب خاص بالشكاوي او الاقتراحات .
ويمكنه من متابعة من خلال الموقع الالكتروني ومعرفة اخر التطورات الخاصة بطلبه',
            'mopile' => '059874689',
            'phone' => '2558658',
            'free_number' => '1800700500',
            'mail' => 'hamms@mail.com',
            'address' => 'غزة - شارع الثلاثيني',
            'fax' => '23907387 (02)',
        ]);
        /*************************/
        $user_id = DB::table('users')->insertGetId([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);

        $circle_id = DB::table('circles')->insertGetId([
            'name' => 'دائرة المدراء',
        ]);
        $account_id = DB::table('accounts')->insertGetId([
            'full_name' => 'admin',
            'mobile' => '+972 599 624984',
            'user_id' => $user_id,
            'email' => 'admin@gmail.com',
            'type' => '1',
            'circle_id' => $circle_id,
            'user_name' => "admin11",
            'job_name' => 'محاسبة',
        ]);
        $link_id = DB::table('links')->insertGetId([
            'title' => 'الحسابات',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        $link2 = DB::table('links')->insertGetId([
            'title' => 'ادارة الحسابات',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/account',
            'show_menu'=>1,
        ]);
        $link3 = DB::table('links')->insertGetId([
            'title' => 'اضافة حسابات',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/account/create',
            'show_menu'=>1,
        ]);
        $link4 = DB::table('links')->insertGetId([
            'title' => 'تعديل حسابات',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/account/edit',
            'show_menu'=>0,
        ]);
        $link5 = DB::table('links')->insertGetId([
            'title' => 'حذف حسابات',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/account/destroy',
            'show_menu'=>0,
        ]);
        /****************************************************/
        DB::table('account_link')->insertGetId([
            'account_id' => $account_id,
            'link_id' => $link_id,

        ]);
        DB::table('account_link')->insertGetId([
            'account_id' => $account_id,
            'link_id' => $link2,
        ]);
        DB::table('account_link')->insertGetId([
            'account_id' => $account_id,
            'link_id' => $link3,
        ]);
        DB::table('account_link')->insertGetId([
            'account_id' => $account_id,
            'link_id' => $link4,
        ]);
        DB::table('account_link')->insertGetId([
            'account_id' => $account_id,
            'link_id' => $link5,
        ]);
        /************************************/
        $link_id = DB::table('links')->insertGetId([
            'title' => 'اعدادات الموقع',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        $com_id = Company::all()->first()->id;
        DB::table('links')->insertGetId([
            'title' => 'تعديل اعدادات الموقع',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => "/account/company/$com_id/edit",
            'show_menu'=>1,
        ]);
		DB::table('links')->insertGetId([
            'title' => 'عرض رسائل الزوار',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => "/account/message",
            'show_menu'=>1,
        ]);
        /***********************************/

        $link_id = DB::table('links')->insertGetId([
            'title' => 'النماذج',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        $form_id=DB::table('links')->insertGetId([
            'title' => 'ادارة النماذج',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/form',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'ادارة الشكاوي',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/form?type=1',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'اضافة نموذج',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/#تقديم الطلب',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'الرد على النماذج',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '',
            'show_menu'=>1,
        ]);
        /****************************************/
        $link_id = DB::table('links')->insertGetId([
            'title' => 'المواطنين',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'ادارة المواطنين',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/citizen',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'اضافة مواطن',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/citizen/create',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'تعديل مواطن',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/citizen/edit',
            'show_menu'=>0,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'حذف مواطن',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/citizen/destroy',
            'show_menu'=>0,
        ]);
        /****************************************/

        $link_id = DB::table('links')->insertGetId([
            'title' => 'المشاريع',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'ادارة المشاريع',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/project',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'اضافة مشروع',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/project/create',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'تعديل مشروع',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/project/edit',
            'show_menu'=>0,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'حذف مشروع',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/project/destroy',
            'show_menu'=>0,
        ]);
        /****************************************/

        $link_id = DB::table('links')->insertGetId([
            'title' => 'فئات الشكاوي',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'ادارة فئات الشكاوي',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/category',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'اضافة فئة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/category/create',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'تعديل فئة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/category/edit',
            'show_menu'=>0,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'حذف فئة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/category/destroy',
            'show_menu'=>0,
        ]);
        /****************************************/

        $link_id = DB::table('links')->insertGetId([
            'title' => 'الدوائر الوظيفية',
            'icon' => 'icon-diamond',
            'parent_id' => 0,
            'url' => '',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'ادارة الدوائر الوظيفية',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/circle',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'اضافة دائرة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/circle/create',
            'show_menu'=>1,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'تعديل دائرة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/circle/edit',
            'show_menu'=>0,
        ]);
        DB::table('links')->insertGetId([
            'title' => 'حذف دائرة دائرة',
            'icon' => '',
            'parent_id' => $link_id,
            'url' => '/account/circle/destroy',
            'show_menu'=>0,
        ]);
        /****************************************/
        //المشروع العام
        $link_id = DB::table('projects')->insertGetId([
            'id' => '1',
            'name' => 'الغير مستفيدين',
            'code' => '-',
            'start_date' => '1979-01-01',
            'end_date' => '1979-01-01',
            'active' => '1',
        ]);
        /****************************************/
        //فئات الشكاوي
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'شكر',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'اقتراح',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'طلب تحديث معلومات مستفيد',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'طلب الحصول على معلومات حول الأنشطة',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'طلب الإستفادة من أنشطة أخرى للمشروع',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'اعتراض على استهداف غير عادل',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'مدى موائمة التدخل وطبيعة النشاط',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'سوء معاملة موظفي المركز',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'شكوى ذات حساسية للنوع الأجتماعي أو حماية الطفولة ',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'طلب استفادة من مشروع',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'استفسار عن معايير الاستفادة من مشروع محدد',
        ]);
        $link_id = DB::table('categories')->insertGetId([
            'name' => 'أخرى',
        ]);

        /****************************************/
        //الداتا الثابتة
        DB::table('project_status')->insertGetId([
            'id' => '1',
            'names' => 'فعال',
        ]);
        DB::table('project_status')->insertGetId([
            'id' => '2',
            'names' => 'غير فعال',
        ]);
        /****************/
        DB::table('sent_type')->insertGetId([
            'id' => '1',
            'namesen' => 'عبر الإنرنت',
        ]);
        DB::table('sent_type')->insertGetId([
            'id' => '2',
            'namesen' => 'عبر زيارة لمقر الشركة',
        ]);
        DB::table('sent_type')->insertGetId([
            'id' => '3',
            'namesen' => 'غير اتصال هاتفي',
        ]);
         DB::table('sent_type')->insertGetId([
            'id' => '4',
            'namesen' => 'عبر زيارة ميدانية',
        ]);
        
        /****************/
        DB::table('form_status')->insertGetId([
            'id' => '1',
            'namefs' => 'قيد الدراسة',
        ]);
        DB::table('form_status')->insertGetId([
            'id' => '2',
            'namefs' => 'تم الرد',
        ]);
        DB::table('form_status')->insertGetId([
            'id' => '3',
            'namefs' => 'تم الإيقاف',
        ]);
        DB::table('form_status')->insertGetId([
            'id' => '4',
            'namefs' => 'عالقة للتأخير',
        ]);
        /************************/
        DB::table('form_type')->insertGetId([
            'id' => '1',
            'namet' => 'شكوى',
        ]);
        DB::table('form_type')->insertGetId([
            'id' => '2',
            'namet' => 'اقتراح',
        ]);
        DB::table('form_type')->insertGetId([
            'id' => '3',
            'namet' => 'شكر',
        ]);
        /***************************/
        DB::table('account_rate')->insertGetId([
            'id' => '1',
            'namera' => 'مدير',
        ]);
        DB::table('account_rate')->insertGetId([
            'id' => '2',
            'namera' => 'مشرف',
        ]);
        DB::table('account_rate')->insertGetId([
            'id' => '3',
            'namera' => 'منسق',
        ]);
        DB::table('account_rate')->insertGetId([
            'id' => '4',
            'namera' => 'ممول',
        ]);
        DB::table('account_rate')->insertGetId([
            'id' => '5',
            'namera' => 'لجنة',
        ]);
        DB::table('account_rate')->insertGetId([
            'id' => '6',
            'namera' => 'موظف',
        ]);
		/***************************************/
		 DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '1',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '2',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '3',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '4',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '5',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '6',
        ]);
			 DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '7',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '8',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '9',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '10',
        ]);
        DB::table('circle_categorie')->insertGetId([
            'circle_id' => '1',
            'category_id' => '11',
        ]);

    }
}
