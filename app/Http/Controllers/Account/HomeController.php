<?php

namespace App\Http\Controllers\Account;

use App\Project;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Session;
use App\Http\Requests\ChangePasswordRequest;
use User;
use App\Account;
use PDO;
use Config;
use Illuminate\Support\Facades\Auth;


class HomeController extends BaseController
{

    public function dashboard()
    {
        $item = auth()->user()->account;
        $items = Account::find(auth()->user()->account->id)->projects()->orderBy("id")->paginate(5);
        Project::where('end_date','<=',Carbon::now())->update(['active' => '2']);

        return view("account.home.dashboard", compact('items', 'item'));
    }

    public function backup()
    {
        $mydb = Config::get('database.connections.mysql.database');
        $myhost = Config::get('database.connections.mysql.host');
        $myusername = Config::get('database.connections.mysql.username');
        $mypassword = Config::get('database.connections.mysql.password');
        $connect = new PDO("mysql:host=$myhost;dbname=$mydb", $myusername, $mypassword);
        $connect->exec("set names utf8");

        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        if (isset($_POST['table'])) {

            $output = '';
            foreach ($_POST["table"] as $table) {

                $show_table_query = "SHOW CREATE TABLE " . $table . "";
                $statement = $connect->prepare($show_table_query);
                $statement->execute();
                $show_table_result = $statement->fetchAll();

                foreach ($show_table_result as $show_table_row) {

                    $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
                }

                $select_query = "SELECT * FROM " . $table . "";
                $statement = $connect->prepare($select_query);
                $statement->execute();
                $total_row = $statement->rowCount();


                for ($count = 0; $count < $total_row; $count++) {

                    $single_result = $statement->fetch(PDO::FETCH_ASSOC);
                    $table_column_array = array_keys($single_result);

                    $table_value_array = array_values($single_result);

                    $output .= "\nINSERT INTO $table (";
                    $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                    $output .= "'" . implode("','", $table_value_array) . "');\n";


                }

            }

            $file_name = 'database_backup_on_' . date('y-m-d') . '.sql';
            $file_handle = fopen($file_name, 'w+');
            fwrite($file_handle, $output);
            fclose($file_handle);

            $file = public_path() . "/$file_name";
            $headers = array('Content-Encoding: UTF-8',
                'Content-Type' => 'text/txt',);
            //dd(File::get($file));
            return response()->download($file, "$file_name", $headers)->deleteFileAfterSend(true);;

        }
        return view('backup', compact('result'));

    }

    public function changePassword()
    {
        return view("account.home.change-password");
    }

    public function noaccess()
    {
        return view("account.home.noaccess");
    }

    public function changePasswordPost(ChangePasswordRequest $request)
    {
        $credentials = [
            'email' => Auth::user()->email,
            'password' => $request->old_password
        ];

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $user->password = bcrypt($request["password"]);
            $user->save();

            Session::flash("msg", "s:تم تغيير كلمة المرور بنجاح");
        } else {
            Session::flash("msg", "e: كلمة المرور الحالية غير صحيحة");
        }
        return redirect('/account/home/change-password');
    }
}
