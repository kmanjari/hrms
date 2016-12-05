<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Models\Employee;
use App\User;
use Illuminate\Http\Request;


class ExpenseController extends Controller
{
    public function addExpense()
    {

        $emps = User::get();
        return view('hrms.expense.add_expense', compact('emps'));
    }

    public function processExpense(Request $request)
    {
        $expense = new Expense();
        $expense->user_id = $request->emp_id;
        $expense->item = $request->item;
        $expense->purchase_from = $request->purchase_from;
        $expense->date_of_purchase = date_format(date_create($request->date_of_purchase), 'Y-m-d');
        $expense->amount = $request->amount;
        $expense->save();

        \Session::flash('flash_message', 'Expense successfully added!');
        return redirect()->back();

    }

    public function showExpense()
    {
        $expenses = Expense::with('employee')->paginate(5);
        return view('hrms.expense.show_expenses', compact('expenses'));
    }

    public function showEdit($id)
    {

        $expenses = Expense::with('employee')->where('id', $id)->first();
        $emps = Employee::get();
        return view('hrms.expense.edit_expense', compact('emps', 'expenses'));
    }

    public function doEdit($id, Request $request)
    {

        $expense = Expense::with('employee')->where('id', $id)->first();
        $expense->user_id = $request->emp_id;
        $expense->item = $request->item;
        $expense->purchase_from = $request->purchase_from;
        $expense->date_of_purchase = date_format(date_create($request->date_of_purchase), 'Y-m-d');
        $expense->amount = $request->amount;
        $expense->save();


        \Session::flash('flash_message', 'Expense successfully updated!');
        return redirect('expense-list');

    }

    public function doDelete($id)
    {
        $expense = Expense::find($id);
        $expense->delete();

        \Session::flash('flash_message', 'Expense successfully Deleted!');
        return redirect('expense-list');

    }
}
