@extends('layouts.app')
@section('css')
    <link href='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-lightness/jquery-ui.css' rel='stylesheet'>
@endsection
@section('content')
    <div class="mt-4">
        <div class="d-flex justify-content-between mb-4">
            <h4>ایجاد تودو</h4>
        </div>
        <div class="bt-4">
            <form action="{{ route('todos.store') }}" method="post">
                @csrf

                <div class="row mb-3">
                    <label for="due_date" class="col-md-4 col-form-label text-md-end">تاریخ سررسید</label>

                    <div class="col-md-6">
                        <input id="due_date" type="text" id="due_date" class="form-control @error('due_date') is-invalid @enderror" name="due_date" value="{{ old('due_date') }}" dir="ltr" autocomplete="off" autofocus>

                        @error('due_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">عنوان</label>

                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" dir="rtl" autocomplete="off" autofocus>

                        @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="tag" class="col-md-4 col-form-label text-md-end">برچسب</label>

                    <div class="col-md-6">
                        <select name="tag" id="tag" class="form-control @error('title') is-invalid @enderror">
                            <option value="">انتخاب نمایید</option>
                            @foreach (\App\Enums\TodoTag::toArray() as $tag)
                                <option value="{{ $tag['id'] }}">{{ $tag['title'] }}</option>
                            @endforeach
                        </select>
                        @error('tag')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label class="col-md-4"></label>
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-primary btn-sm">ثبت</button>
                            <a href="{{ route('todos.index') }}" class="btn btn-warning btn-sm">انصراف</a>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> 
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $( "#due_date" ).datepicker();
        });
    </script>
@endsection