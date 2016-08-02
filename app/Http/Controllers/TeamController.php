<?php
namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Team;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Http\Requests;

class TeamController extends Controller
{
    public function addTeam()
    {
        $emps = Employee::get();
        $managers = Employee::whereHas('userrole', function($q)
        {
            $q->where('role_id', '16');
        })->get();

        $leaders = Employee::whereHas('userrole', function($q)
        {
            $q->where('role_id', '5');
        })->get();

        return view('hrms.team.add_team', compact('emps', 'managers', 'leaders'));
    }

    public function processTeam(Request $request)
    {
        $team_id = Team::max('team_id');
        if(!$team_id) {
            $team_id = 1;
        }
        else{
            $team_id = $team_id+1;
        }
        foreach($request->member_id as $memberId)
        {
            $addTeam = new Team();
            $addTeam->name = $request->team_name;
            $addTeam->team_id = $team_id;
            $addTeam->manager_id = $request->manager_id;
            $addTeam->leader_id = $request->leader_id;
            $addTeam->member_id = $memberId;
            $addTeam->save();
        }

        \Session::flash('flash_message', 'Team successfully added!');
        return redirect()->back();
    }

    public function showTeam()
    {
        $teams = Team::with(['employee', 'leader', 'manager'])->paginate(5);
        return view('hrms.team.show_team',compact('teams'));
    }

    public function showEdit($id)
    {
        $managers = Employee::whereHas('userrole', function($q)
        {
            $q->where('role_id', '16');
        })->get();

        $leaders = Employee::whereHas('userrole', function($q)
        {
            $q->where('role_id', '5');
        })->get();

        $emps = Employee::get();

        $edit = Team::with(['manager','leader','employee'])->where('team_id', $id)->get();

        $team_member = [];
        foreach($edit as $ed)
        {
            $team_member[] = $ed->employee->id;
        }
        return view('hrms.team.edit_team', compact('edit', 'managers', 'leaders', 'emps', 'team_member'));
    }

    public function doEdit(Request $request,$id)
    {

            $name = $request->team_name;
            $team_id = $request-> team_id;
            $manager_id = $request->manager_id;
            $leader_id = $request->leader_id;

            $edit= Team::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($team_id)) {
            $edit->team_id = $team_id;
        }
        if (!empty($manager_id)) {
            $edit->manager_id = $manager_id;
        }
        if (!empty($leader_id)) {
            $edit->leader_id = $leader_id;
        }
        $edit->save();

        \Session::flash('flash_message', 'Team successfully updated!');
        return redirect('team-listing');


    }

    public function doDelete($id)
    {
        $team = Team::find($id);
        $team->delete();

        \Session::flash('flash_message', 'Team successfully Deleted!');
        return redirect('team-listing');
    }

    public function test()
    {
        $team_id = Team::max('team_id');
        $team_id = $team_id+1;


    }


}