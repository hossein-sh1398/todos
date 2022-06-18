@extends('layouts.app')
@section('css')
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
@endsection
@section('content')
    <div>
        <div class="d-flex justify-content-between mb-4">
            <h4>لیست تودوها</h4>
            @if (!auth()->user()->isAdmin())
                <a href="{{ route('todos.create') }}" class="btn btn-success">ایجاد</a>
            @endif
        </div>
        @if (auth()->user()->isAdmin())
            <div class="search mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <h5>جستجو : </h5>
                        <form action="{{ route('todos.index') }}">
                            <div class="row">
                                <div class="col-md-3">
                                    <label>تگ</label>
                                    <select name="tag" class="form-control">
                                        <option value="">انتخاب نمایید</option>
                                        @foreach (\App\Enums\TodoTag::toArray() as $tag)
                                            <option value="{{ $tag['id'] }}" {{ $tag['id'] == request('tag') ? 'selected' : '' }}>{{ $tag['title'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>تاریخ شروع</label>
                                    <input type="text" id="due_date_start" class="form-control" name="due_date_start" value="{{ request('due_date_start') }}" dir="ltr">
                                </div>
                                <div class="col-md-3">
                                    <label>تاریخ پایان</label>
                                    <input type="text" id="due_date_end" class="form-control" name="due_date_end" value="{{ request('due_date_end') }}" dir="ltr">
                                </div>
                                <div class="col-md-3" style="padding-top: 20px">
                                    <button class="btn btn-primary">فیلتر</button>
                                    <a href="{{ route('todos.index') }}" class="btn btn-warning">حذف فیلتر</a>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        @endif
        <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">آدی</th>
            <th scope="col">عنوان</th>
            <th scope="col">تاریخ سر رسید</th>
            <th scope="col">وضعیت</th>
            <th scope="col">برچسب</th>
            <th scope="col">عملیات</th>
          </tr>
        </thead>
        <tbody>
            @forelse($todos as $todo)
                <tr>
                    <th scope="row">{{ $todo->id }}</th>
                    <td>{{ $todo->title }}</td>
                    <td>{{ $todo->due_date }}</td>
                    <td>{{ \App\Enums\StatusTodo::getTitle($todo->status) }}</td>
                    @php
                        $tag = \App\Enums\TodoTag::getTitle($todo->tag);
                    @endphp
                    <td><span style="background:{{ $tag['code'] }}" class="todo-tag"></span></td>
                    <td>
                        @if (auth()->user()->isAdmin())
                            @if ($todo->status == \App\Enums\StatusTodo::Registered)
                                <a href="{{ route('todos.confirmed', $todo->id) }}" class="btn btn-success btn-sm">تایید</a>
                                <a href="{{ route('todos.unconfirmed', $todo->id) }}" class="btn btn-warning btn-sm">رد کردن</a>
                                <input type="checkbox" value="{{ $todo->id }}" class="select-todo" name="todos[]">
                                <span>انتخاب</span>
                            @endif
                        @else
                            <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm">ویرایش</a>
                            @if (($todo->status ==  \App\Enums\StatusTodo::Confirmed) && (date('Y-m-d') < $todo->due_date))
                                <a href="{{ route('todos.done', $todo->id) }}" class="btn btn-success btn-sm">انجام شده</a>
                            @endif
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">
                        <p class="alert alert-info">
                            لیست خالی می باشد
                        </p>
                    </td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr style="text-align: left">
                <td colspan="6">
                    @foreach($todos as $key => $todo)
                        @if (auth()->user()->isAdmin())
                            @if ($todo->status == \App\Enums\StatusTodo::Registered)
                                <a href="#" onclick="multiConfirmed(event)" class="btn btn-success btn-sm">تایید چندتایی</a>
                                <a href="#" onclick="multiUnConfirmed(event)" class="btn btn-warning btn-sm">رد چندتایی</a>
                                @break
                            @endif
                        @endif
                     @endforeach
                </td>
            </tr>
        </tfoot>
      </table>
      @if ($todos->isNotEmpty())
        <div class="mt-3">
            {{  $todos->links()  }}
        </div>
      @endif
    </div>
@endsection

@section('js')
    @foreach($todos as $key => $todo)
        @if (auth()->user()->isAdmin())
            @if ($todo->status == \App\Enums\StatusTodo::Registered)
                <script src="{{ url('js/jquery.min.js') }}"></script> 
                <script>
                    function multiConfirmed(e) {
                        e.preventDefault();
                        var ids = new Array();
                        var items = document.getElementsByClassName('select-todo');
                        for (item of items) {
                            if (item.checked) {
                                ids.push(item.value);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("multi-confirmed") }}',
                        data: {ids:ids},
                        success: function (res) {
                            if (res == 1) {
                                location.reload();
                            }
                        } 
                    });
                    }

                    function multiUnConfirmed(e) {
                        e.preventDefault();
                        var ids = new Array();
                        var items = document.getElementsByClassName('select-todo');
                        for (item of items) {
                            if (item.checked) {
                                ids.push(item.value);
                            }
                        }

                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        alert(ids);
                    $.ajax({
                        type: 'POST',
                        url: '{{ route("multi-un-confirmed") }}',
                        data: {ids:ids},
                        success: function (res) {
                            if (res == 1) {
                                location.reload();
                            }
                        } 
                    });
                    }
                </script>
                @break
            @endif
        @endif
    @endforeach

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $( "#due_date_start" ).datepicker();
            $( "#due_date_end" ).datepicker();
        });
    </script>
@endsection