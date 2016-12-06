<?php

namespace App\Http\Controllers;

use App\Award;
use App\Awardee;
use App\Models\Employee;
use App\User;
use Illuminate\Http\Request;


class AwardController extends Controller
{
    public function addAward(){

        return view('hrms.award.add_award');
    }

    public function processAward(Request $request){

        $award = new Award;
        $award->name = $request->name;
        $award->description = $request->description;
        $award->save();

        \Session::flash('flash_message', 'Award successfully added!');
        return redirect()->back();
    }

    public function showAward(){
        $awards = Award::paginate(10);
        return view('hrms.award.show_award', compact('awards'));
    }

    public function showAwardEdit($id){
       $awards = Award::whereid($id)->first();
        return view('hrms.award.edit_award', compact('awards'));
    }

    public function doAwardEdit($id,Request $request){
        $name = $request->name;
        $description = $request->description;

        $edit = Award::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();

        \Session::flash('flash_message', 'Award successfully updated!');
        return redirect('award-listing');
    }

    public function doAwardDelete($id){
        $award = Award::find($id);
        $award->delete();

        \Session::flash('flash_message', 'Award successfully deleted!');
        return redirect('award-listing');
    }

    public function assignAward(){

        $emps = User::get();
        $awards = Award::get();
        return view('hrms.award.assign_award',compact('emps','awards'));
    }

    public function processAssign(Request $request){
        $awardee = new Awardee();
        $awardee->user_id = $request->emp_id;
        $awardee->award_id = $request->award_id;
        $awardee->date = date_format(date_create($request->date), 'Y-m-d');
        $awardee->reason = $request->reason;
        $awardee->save();

        \Session::flash('flash_message', 'Award successfully assigned!');
        return redirect()->back();

    }

    public function showAwardAssign(){

        $assigns = Awardee::with(['employee','award'])->paginate(5);
        return view('hrms.award.show_awardees', compact('assigns'));
    }

    public function showAssignEdit($id){

        $assigns = Awardee::with(['employee', 'award'])->where('id', $id)->first();

        $emps = Employee::get();
        $awards = Award::get();
        return view('hrms.award.edit_award_assignment', compact('assigns', 'emps', 'awards'));
    }

    public function doAssignEdit($id, Request $request){
        $user_id = $request->emp_id;
        $award_id = $request->award_id;
        $date = $request->date;
        $reason = $request->reason;

        $edit = Awardee::findOrFail($id);
        if (!empty($user_id)) {
            $edit->user_id = $user_id;
        }
        if (!empty($award_id)) {
            $edit->award_id = $award_id;
        }
        if (!empty($date)) {
            $edit->date = $date;
        }
        if (!empty($reason)) {
            $edit->reason = $reason;
        }
        $edit->save();

        \Session::flash('flash_message', 'Award Assignment successfully updated!');
        return redirect('awardees-listing');


    }

    public function doAssignDelete($id){

        $assigns = Awardee::find($id);
        $assigns->delete();

        \Session::flash('flash_message', 'Award Assignment successfully deleted!');
        return redirect('awardees-listing');
    }
}
