<?php

namespace App\Http\Controllers;

use App\TrainingInvite;
use App\TrainingProgram;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class TrainingController extends Controller
{
    public function addTrainingProgram(){
        return view('hrms.training.add_program');
    }

    public function processTrainingProgram(Request $request){
       $programs = new TrainingProgram();
       $programs->name = $request->name;
       $programs->description = $request->description;
       $programs->save();

        \Session::flash('flash_message', 'Training Program successfully added!');
        return redirect()->back();

    }

    public function showTrainingProgram(){
        $programs = TrainingProgram::paginate(10);
        return view('hrms.training.show_program',compact('programs'));
    }

    public function doEditTrainingProgram($id){
        $programs = TrainingProgram::whereid($id)->first();
        return view('hrms.training.edit_program', compact('programs'));

    }

    public function processEditTrainingProgram($id,Request $request){
        $name = $request->name;
        $description = $request->description;

        $edit = TrainingProgram::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();

        \Session::flash('flash_message', 'Training Program successfully updated!');
        return redirect('show-training-program');

    }
    public function deleteTrainingProgram($id){
        $program = TrainingProgram::find($id);
        $program->delete();

        \Session::flash('flash_message', 'Training Program successfully deleted!');
        return redirect('show-training-program');
    }

    public function addTrainingInvite(){

        $emps=User::get();
        $programs= TrainingProgram::get();
        return view('hrms.training.add_training_invite',compact('emps','programs'));
    }

    public function processTrainingInvite(Request $request)
    {

        $totalMembers = count($request->member_ids);
        $i = 0;
        try
        {
            foreach ($request->member_ids as $member_id)
            {
                $check = TrainingInvite::where(['program_id' => $request->program_id, 'user_id' => $member_id])->first();
                if(!$check)
                {
                    $invites = new TrainingInvite();
                    $invites->user_id = $member_id;
                    $invites->program_id = $request->program_id;
                    $invites->description = $request->description;
                    $invites->date_from = date_format(date_create($request->date_from), 'Y-m-d');
                    $invites->date_to = date_format(date_create($request->date_to), 'Y-m-d');
                    $invites->save();
                    $i++;
                }
            }
        }
        catch(\Exception $e)
        {
            \Log::info($e->getMessage(). ' on '. $e->getLine(). ' in '. $e->getFile());
        }

        \Session::flash('flash_message', $i . ' out of '. $totalMembers. ' members have been invited for the training!');
        return redirect()->back();
    }

    public function showTrainingInvite()
    {
        $invites = TrainingInvite::with(['employee','program'])->paginate(15);
        return view('hrms.training.show_training_invite',compact('invites'));
    }

    public function doEditTrainingInvite($id)
    {
        $training = TrainingInvite::with(['employee', 'program'])->findOrFail($id);
        $programs = TrainingProgram::get();
        foreach($programs as $program)
        {
            $prog[$program->id] = $program->name;
        }
        $training->programs = $prog;
        return view('hrms.training.edit_training_invite', compact('training'));
    }

    public function processEditTrainingInvite($id, Request $request)
    {
        $model = TrainingInvite::where('id', $id)->firstOrFail();
        $model->program_id = $request->program_id;
        $model->description = $request->description;
        $model->date_from = $request->date_from;
        $model->date_to = $request->date_to;
        $model->save();

        \Session::flash('flash_message', 'Training Program successfully updated!');
        return redirect('show-training-invite');
    }

    public function deleteTrainingInvite($id){
            $invite = TrainingInvite::where('id',$id);
            $invite->delete();

            \Session::flash('flash_message', 'Member successfully removed!');
            return redirect('show-training-invite');
    }

}
