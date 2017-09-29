<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Project;
use Illuminate\Http\Request;
use App\User;
use App\Models\AssignProject;
use App\Models\Employee;

use App\Http\Requests;

class ProjectController extends Controller
{
    public function addProject()
    {
        $clients = User::whereHas('role', function ($q) {
            $q->where('role_id', '5');
        })->get();
        return view('hrms.project.add-project', compact('clients'));
    }

    public function validateCode($code)
    {

        $client = Client::where('code', $code)->first();
        if ($client) {
             json_encode(['status' => false]);
        }
        // json_encode(['status' => true]);
    }

    public function processProject(Request $request)
    {
        $project = new Project;
        $project->name = $request->project_name;
        $project->description = $request->description;
      //  $project->fill(array_except($request->all(),'_token'));
        $project->code= $request->code;
        $project->client_id = $request->client_id;
        $project->save();
        \Session::flash('flash_message', 'Project successfully added!');
        return redirect()->back();
    }

    public function saveProject(Request $request)
    {
        $project = new Project;
        $project->name = $request->project_name;
        $project->code= $request->code;
        $project->description = $request->description;
        $project->client_id = $request->client_id;
        $project->save();
        \Session::flash('flash_message', 'project successfully added');
        return redirect()->back();

    }
    public function listProject()
    {
        $projects = project::paginate(5);
        return view('hrms.project.show-project', compact('projects'));
    }
    public function showEdit($id)
    {
        $results = Client::get();
        $clients = [];
        foreach($results as $result)
        {
            $clients[$result->id] = $result->name;
        }

        $result = project::whereid($id)->first();
        return view('hrms.project.add-project', compact('result', 'clients'));
    }

    public function doEdit(Request $request, $id)
    {
        $name = $request->name;
        $description = $request->description;

        $edit = project::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
            $edit->save();
        \Session::flash('flash_message', 'project successfully updated!');
        return redirect('list-project');
    }

    public function doDelete($id)
    {
        $project = project::find($id);
        $project->delete();
        \Session::flash('flash_message', 'Project successfully Deleted!');
        return redirect('list-project');
    }

    public function doAssign()
    {
        $emps = User::get();
        $projects = Project::get();
        return view('hrms.project.assign-project', compact('emps', 'projects'));
    }

    public function processAssign(Request $request)
    {
        $assignment = new AssignProject();
        $assignment->user_id = $request->emp_id;
        $assignment->project_id = $request->project_id;
        $assignment->authority_id = $request->authority_id;
        $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
        $assignment->date_of_release = date_format(date_create($request->dor), 'Y-m-d');
        $assignment->save();

        \Session::flash('flash_message', 'Project successfully assigned!');
        return redirect()->back();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showProjectAssignment()
    {
        $projects = AssignProject::with(['employee','authority', 'project'])->paginate(5);
        return view('hrms.project.show-project-assignment', compact('projects'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showEditAssign($id)

    {
        $assigns = AssignProject::with(['employee', 'project'])->where('id', $id)->first();

        $emps = Employee::get();
        $projects = project::get();
        return view('hrms.project.edit-project-assignment', compact('assigns', 'emps', 'projects'));
    }

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doEditAssign($id, Request $request)

    {
        $assignment = AssignProject::with(['employee', 'project'])->where('id', $id)->first();
        $assignment->user_id = $request->emp_id;
        $assignment->project_id = $request->project_id;
        $assignment->authority_id = $request->authority_id;
        $assignment->date_of_assignment = date_format(date_create($request->doa), 'Y-m-d');
        $assignment->date_of_release = date_format(date_create($request->dor), 'Y-m-d');
        $assignment->save();


        \Session::flash('flash_message', 'project Assignment successfully updated!');
        return redirect('assignment-listing');
    }


    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function doDeleteAssign($id)
    {
        $assign = AssignProject::find($id);
        $assign->delete();

        \Session::flash('flash_message', 'Project Assignment successfully Deleted!');
        return redirect('assignment-listing');
    }
}
