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
        $emps = User::get();
        $managers = User::whereHas('role', function ($q) {
            $q->where('role_id', '16');
        })->get();

        $leaders = User::whereHas('role', function ($q) {
            $q->where('role_id', '5');
        })->get();

        return view('hrms.team.add_team', compact('emps', 'managers', 'leaders'));
    }

    public function processTeam(Request $request)
    {
        $team_id = Team::max('team_id');
        if (!$team_id) {
            $team_id = 1;
        } else {
            $team_id = $team_id + 1;
        }
        foreach ($request->member_id as $memberId) {
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
        return view('hrms.team.show_team', compact('teams'));
    }

    public function showEdit($id)
    {
        $managers = User::whereHas('role', function ($q) {
            $q->where('role_id', '16');
        })->get();

        $leaders = User::whereHas('role', function ($q) {
            $q->where('role_id', '5');
        })->get();

        $emps = User::get();

        $edit = Team::with(['manager', 'leader', 'employee'])->where('team_id', $id)->get();

        $team_member = [];
        foreach ($edit as $ed) {
            $team_member[] = $ed->employee->id;
        }
        return view('hrms.team.edit_team', compact('edit', 'managers', 'leaders', 'emps', 'team_member'));
    }

    public function doEdit(Request $request, $id)
    {
        $name = $request->team_name;
        $team_id = $request->id;
        $manager_id = $request->manager_id;
        $leader_id = $request->leader_id;
        $members = $request->member_id;

        $edit = Team::where('team_id', $id)->first();

        if($edit) {
            $oldMembers = Team::where('team_id', $team_id)->get(['member_id']);
            /*$oldLeader = Team::where('team_id', $team_id)->get('leader_id');
            if($oldLeader->leader_id == $leader_id)
            {
                //true condition
            }*/

            foreach ($oldMembers as $oldMember) {
                $oldmembers[] = $oldMember->member_id;
            }
            $oldSize = count($oldmembers);
            $newSize = count($members);

            if ($oldSize < $newSize) {
                //add the remainder
                $idsToAdd = array_diff($members, $oldmembers);

                foreach ($idsToAdd as $add) {
                    $team = new Team();
                    $team->name = $name;
                    $team->team_id = $team_id;
                    $team->manager_id = $manager_id;
                    $team->leader_id = $leader_id;
                    $team->member_id = $add;
                    $team->save();
                }
                \Session::flash('flash_message', 'Team member successfully added!');
            } elseif($oldSize > $newSize) {
                //delete the remainder
                $idsToDelete = array_diff($oldmembers, $members);
                \DB::table('teams')->where('team_id', $team_id)->whereIn('member_id', $idsToDelete)->delete();
                \Session::flash('flash_message', 'Team member successfully deleted !');
            }else
            {
                $team = Team::where('team_id', $team_id)->first();
                $team->name = $name;
                $team->team_id = $team_id;
                $team->leader_id = $leader_id;
                $team->save();
            }


        }
        else
        {
            \Session::flash('flash_message', 'Team not found!');
        }

        return redirect('team-listing');

    }

    public function doDelete($id)
    {
        $team = Team::where('member_id',$id);
        $team->delete();

        \Session::flash('flash_message', 'Team member successfully removed!');
        return redirect('team-listing');
    }

    public function test()
    {
        $team_id = Team::max('team_id');
        $team_id = $team_id + 1;


    }


}