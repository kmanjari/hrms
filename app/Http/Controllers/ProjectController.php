<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Employee;
use App\Models\Project;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProjectController extends Controller
{
    public function addProject()
    {
        $model = new \stdClass();
        $model->clients = Client::get();
        return view('hrms.projects.add', compact('model'));
    }

    public function saveProject(Requests\AddProjectRequest $request)
    {
        $project = new Project();
        $project->fill(array_except($request->all(), '_token'));
        $project->save();

        \Session::flash('flash_message', 'Project added successfully');

        return redirect()->back();
    }

    public function showEdit($projectId)
    {
        $model = new \stdClass();
        $model->project = Project::with('client')->findOrFail(['id' => $projectId]);
        return $model;
        $model->clients = Client::get();
        return view('hrms.projects.edit', compact('model'));
    }

    public function saveProjectEdit(Request $request, $projectId)
    {

    }

    public function listProject()
    {
        $projects = Project::with('client')->paginate(15);
        return view('hrms.projects.list', compact('projects'));
    }

    public function assignProject()
    {
        $model = new \stdClass();
        $model->projects = Project::get();
        $model->employees = Employee::whereHas('userrole', function($q)
        {
            $q->whereIn('role_id', ['3', '4']);
        })
            ->get();

        return view('hrms.projects.assign', compact('model'));
    }
}
