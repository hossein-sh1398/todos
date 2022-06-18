<?php

namespace App\Http\Controllers;

use App\Enums\StatusTodo;
use App\Http\Requests\Todos\StoreTodoRequest;
use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        $this->middleware('IsUser')->only([
            'create',
            'store',
            'edit',
            'update',
            'done'
        ]);

        $this->middleware('IsAdmin')->only([
            'unconfirmed',
            'confirmed',
            'multiConfirmed',
            'multiUnConfirmed',
        ]);
    }

    public function index()
    {
        $todos = Todo::when(request('tag'), function ($query) {
           return  $query->where('tag', request('tag'));
        })->when(request('due_date_start'), function ($query) {
            $date = date('Y-m-d', strtotime(request('due_date_start')));

            return  $query->whereDate('due_date', '>=', $date);
         })->when(request('due_date_end'), function ($query) {
            $date = date('Y-m-d', strtotime(request('due_date_end')));

            return  $query->whereDate('due_date', '<=', $date);
         })->orderBy('tag', 'desc')->paginate(10);

        return view('todos.index', compact('todos'));
    }

    public function create()
    {
        return view('todos.create');
    }

    public function store(StoreTodoRequest $request)
    {
        Todo::create($request->all());

        alert()->success('مژده','تودو با موفقیت ایجاد شد');

        return back();
    }

    public function edit(Todo $todo)
    {
        return view('todos.edit', compact('todo'));
    }

    public function update(StoreTodoRequest $request, Todo $todo)
    {
        $todo->update($request->validated());

        alert()->success('مژده','تودو با موفقیت ویرایش شد');

        return back();
    }

    public function unconfirmed(Todo $todo) 
    {
        $todo->status = StatusTodo::Failed;

        $todo->save();

        alert()->success('مژده','تودو با موفقیت ویرایش شد');

        return back();
    }

    public function confirmed(Todo $todo)
    {
        $todo->status = StatusTodo::Confirmed;

        $todo->save();

        alert()->success('مژده','تودو با موفقیت ویرایش شد');
        
        return back();
    }

    public function done(Todo $todo)
    {
        $todo->status = StatusTodo::Done;

        $todo->save();

        alert()->success('مژده','تودو با موفقیت ویرایش شد');
        
        return back();
    }

    public function multiConfirmed(Request $request)
    {
        $ids = $request->get('ids');

        Todo::whereIn('id', $ids)->update([
            'status' => StatusTodo::Confirmed, 
        ]);

        alert()->success('مژده','تودو با موفقیت ویرایش شد');

        return 1;
    }

    public function multiUnConfirmed(Request $request)
    {
        $ids = $request->get('ids');

        Todo::whereIn('id', $ids)->update([
            'status' => StatusTodo::Failed, 
        ]);

        alert()->success('مژده','تودو با موفقیت ویرایش شد');
        
        return 1;
    }
}
