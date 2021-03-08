<div class="row">
    <div class="col-md-12">

        <ul class="list-styled" style="direction:rtl;text-align:right;">
            <li>
                <h4> ملحق {{$item->appendix_name}}  </h4>
                <a  style="text-decoration: none;color: #3f688d;"
                    href="{{ route('appendixshow', $item->id) }}">
                    تحميل
                </a>
            </li>
        </ul>
    </div>
</div>



