@extends("layouts._account_layout")
@section("title", " توصيات مستخدمي النظام")


@section("content")
    <div class="row">

        <div class="col-sm-12">
            <h4>يمكنك من خلال هذه الواجهة الاطلاع على توصيات مستخدمي النظام ذات العلاقة بالاقتراحات والشكاوى.</h4>
        </div>

    </div>
    <br>
    <br>

    <div class="form-group row filter-div">
        <div class="col-sm-12">
            <form>
                <div class="row">
                    <div class="col-sm-4">
                        <button type="button" style="width:100px;" class="btn btn-primary adv-search-btn">
                            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                            بحث متقدم
                        </button>
                        <button type="submit" target="_blank" name="theaction" title="تصدير إكسل" style="width:100px;"
                                value="excel" class="btn btn-primary">
                            <span class="glyphicon glyphicon-export" aria-hidden="true"></span>
                            تصدير
                        </button>

                    </div>
                </div>
                <br>

                <div class="row">

                    <div class="col-sm-3 adv-search">
                        <label for="account_id">اسم المستخدم</label>
                        <select name="account_id" class="form-control">
                            <option value="" selected>اسم المستخدم</option>
                            @foreach($accounts as $account)
                                <option
                                    @if(request('account_id')===''.$account->id)selected
                                    @endif
                                    value="{{$account->id}}">{{$account->full_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-3 adv-search">
                        <label for="project_id">اسم المشروع</label>
                        <select name="project_id" class="form-control">
                            <option value="" selected>اسم المشروع</option>
                            <option value="-1" @if(request('project_id')==='-1')selected
                                @endif>جميع المشاريع
                            </option>
                            @foreach($projects as $project)
                                <option
                                    @if(request('project_id')===''.$project->id)selected
                                    @endif
                                    value="{{$project->id}}">{{$project->code." ".$project->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-sm-2 adv-search">
                        <label for="from_date">من تاريخ </label>
                        <input type="text" class="form-control datepicker" name="from_date"
                               value="{{request('from_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>
                    <div class="col-sm-2 adv-search">
                        <label for="to_date">إلى تاريخ </label>
                        <input type="text" class="form-control datepicker" name="to_date" value="{{request('to_date')}}"
                               placeholder="يوم / شهر / سنة"/>
                    </div>

                    <div class="col-sm-2 adv-search">
                        <button type="submit" name="theaction" title="بحث" style="width:70px;margin-top:25px"
                                value="search"
                                class="btn btn-primary"><span class="glyphicon glyphicon-search"
                                                              aria-hidden="true"></span>
                            بحث
                        </button>
                    </div>

                </div>
            </form>
        </div>

    </div>
    <div class="mt-3"></div>
    @if($items)
        @if($items->count()>0)
            <div class="table-responsive">

                <table class="table table-hover table-striped"
                       style="white-space:normal;">
                    <thead>
                    <tr>
                        <th style="word-break: normal;">#</th>
                        <th style="max-width: 250px;word-break: normal;">اسم المستخدم</th>
                        <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                        <th style="max-width: 150px;word-break: normal;">تاريخ رفع التوصيات</th>
                        <th style="max-width: 100px;word-break: normal;">التوصيات</th>
                        <th style="max-width: 110px;word-break: normal;text-align: center;"> تفاصيل ذات علاقة
                            بالتوصيات
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $k=>$a)
                            <tr>
                                <td style="max-width: 100px;word-break: normal;">{{$k+1}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->user->name}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->form->project->name}}</td>
                                <td style="max-width: 100px;word-break: normal;">{{$a->created_at}}</td>
                                <td style="max-width: 200px;word-break: normal;">{{$a->recommendations_content}}</td>
                                <td style="text-align: center">
                                    <?php
                                     $form = \App\Form::find($a->form->id);
                                    ?>
                                    <a class="btn btn-xs btn-primary" href="/citizen/form/show/{{$form->citizen->id_number}}/{{$form->id}}">
                                        <i class="glyphicon glyphicon-eye-open"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>

            </div>
            <br>
            <div style="float:left">{{$items->links()}} </div>
            <br> <br><br>
        @else
            <br><br>
            <div class="alert alert-warning">نأسف لا يوجد بيانات لعرضها</div>


        @endif

    @else

        <table class="table table-hover table-striped" style="white-space:normal;">
            <thead>
            <tr>
                <th style="word-break: normal;">#</th>
                <th style="max-width: 250px;word-break: normal;">اسم المستخدم</th>
                <th style="max-width: 100px;word-break: normal;">اسم المشروع</th>
                <th style="max-width: 150px;word-break: normal;">تاريخ رفع التوصيات</th>
                <th style="max-width: 100px;word-break: normal;">التوصيات</th>
                <th style="max-width: 110px;word-break: normal;text-align: center;"> تفاصيل ذات علاقة بالتوصيات</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>

    @endif

    <div class="modal fade" id="Confirm22" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
         aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">تأكيد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="delete_form_modal">
                    <div class="modal-body">
                        <input type="text" class="form-control" id="deleting_reason" placeholder="سبب الحذف" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء الامر</button>
                        <button id="submit_delete" class="btn btn-danger">تأكيد الحذف</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="smallModal" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel"
         aria-hidden="true" style=" position: absolute;left: 42%;top: 40%;transform: translate(-50%, -50%);">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="smallBody">
                    <div>

                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section("js")

    <script>
        $(document).on('click', '#smallButton', function (event) {
            event.preventDefault();
            let href = $(this).attr('data-attr');
            $.ajax({
                url: href,
                beforeSend: function () {
                    $('#loader').show();
                },
                // return the result
                success: function (result) {
                    $('#smallModal').modal("show");
                    $('#smallBody').html(result).show();
                },
                complete: function () {
                    $('#loader').hide();
                },
                error: function (jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    $('#loader').hide();
                },
                timeout: 8000
            })
        });
    </script>
    <script>
        $(function () {

            $('.adv-search').hide();
            $('.adv-search-btn').click(function () {
                $('.adv-search').slideToggle("fast", function () {
                    if ($('.adv-search').is(':hidden')) {
                        $('#searchonly').show();
                    } else {
                        $('#searchonly').hide();
                    }
                });
            });

        });
    </script>
@endsection
