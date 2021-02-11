@extends("layouts._account_layout")

@section("title", " المشاريع المدرجة ضمنها المستفيد  $item->first_name $item->father_name $item->grandfather_name $item->last_name")


@section("content")
{{-- <div class="col-md-9">
    <h4>هذه الواجهة مخصصة لعرض المشاريع التي يتم الاستفادة منها لهذا المواطن</h4><br>
</div> --}}

    <form method="post" action="/account/citizen/select-project-post/{{$item->id}}">
        @csrf
        <div class="form-group row">

            <div class="col-sm-5">
                <?php
                $projects = \DB::table("projects")->get();
                ?>
                <ul class="list-styled">
                    @foreach($projects as $project)
                        @if($project->id!="1")
                            @if($item->projects->contains($project->id))
                                <li>
                                    <label> <b>{{$project->name}} - {{$project->code}}</b></label>
                                </li>
                            @endif
                        @endif
                    @endforeach
                </ul>

            </div>
        </div>


        <div class="form-group row">
            <div class="col-sm-5">
                {{-- <input type="submit" class="btn btn-success" value="حفظ" /> --}}
                <a href="/account/citizen" class="btn btn-light">رجوع للخلف</a>
            </div>
        </div>
    </form>
@endsection
