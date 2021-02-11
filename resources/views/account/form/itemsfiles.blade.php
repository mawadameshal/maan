<div class="row">
    <div class="col-md-12">
        <h4> مرفقات اقتراح/شكوى رقم {{$item->id}}</h4>
    </div>
</div>

<hr>
<div class="row">
    <div class="col-md-12">
        <ul class="list-styled" style="direction:rtl;text-align:right;">
        @foreach($form_files as $follow_file)
            <li>
                <a  style="text-decoration: none;color: #3f688d;" target="_blank"
                    href="{{asset('/uploads/'.$follow_file['name'])}}">
                      مرفقات اقتراح/شكوى رقم {{$item->id}}
                    - تاريخ الاستخراج {{" ".strtotime($follow_file->created_at)}}
                </a>
            </li>
            <hr style="border:1px solid #CCC">
        @endforeach
        </ul>
    </div>
</div>



