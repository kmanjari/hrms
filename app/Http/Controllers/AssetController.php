<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssignAsset;
use App\Models\Employee;
use Illuminate\Http\Request;

use App\Http\Requests;

class AssetController extends Controller
{

    public function addAsset()
    {
        return view('hrms.asset.add_asset');
    }

    Public function processAsset(Request $request)
    {

        $asset = new Asset;
        $asset->name = $request->name;
        $asset->description = $request->description;
        $asset->save();
        \Session::flash('flash_message', 'Asset successfully added!');
        return redirect()->back();

    }
    public function showAsset()
    {
        $assets = Asset::paginate(5);
        return view('hrms.asset.show_asset', compact('assets'));
    }

    public function showEdit($id)
    {
        $result = Asset::whereid($id)->first();
        return view('hrms.asset.add_asset', compact('result'));
    }

    public function doEdit(Request $request, $id)
    {
        $name = $request->name;
        $description = $request->description;

        $edit = Asset::findOrFail($id);
        if (!empty($name)) {
            $edit->name = $name;
        }
        if (!empty($description)) {
            $edit->description = $description;
        }
        $edit->save();
        \Session::flash('flash_message', 'Asset successfully updated!');
        return redirect('asset-listing');
    }

    public function doDelete($id)
    {
        $asset = Asset::find($id);
        $asset->delete();
        \Session::flash('flash_message', 'Asset successfully Deleted!');
        return redirect('asset-listing');
    }
    public function doAssign()
    {
        $emps = Employee::get();
        $assets = Asset::get();
        return view('hrms.asset.assign_asset',compact('emps','assets'));
    }
    public function processAssign(Request $request)
    {
        $assignment = new AssignAsset();
        $assignment->emp_id = $request->emp_id;
        $assignment->asset_id = $request->asset_id;
        $assignment->doa = date_format(date_create($request->doa), 'Y-m-d');
        $assignment->dor = date_format(date_create($request->dor), 'Y-m-d');
        $assignment->save();

        \Session::flash('flash_message', 'Asset successfully assigned!');
        return redirect()->back();
    }

    public function showAssignment()
    {
        $assets = AssignAsset::with(['employee', 'asset'])->paginate(5);
        return view('hrms.asset.show_assignment', compact('assets'));
    }

    public function showEditAssign($id)

    {
        $assigns = AssignAsset::with(['employee', 'asset'])->where('id', $id)->first();

        $emps = Employee::get();
        $assets = Asset::get();
        return view('hrms.asset.edit_asset_assignment', compact('assigns','emps','assets'));
    }

    public function doEditAssign($id,Request $request)

    {
        $assignment= AssignAsset::with(['employee', 'asset'])->where('id', $id)->first();
        $assignment->emp_id = $request->emp_id;
        $assignment->asset_id = $request->asset_id;
        $assignment->doa = date_format(date_create($request->doa), 'Y-m-d');
        $assignment->dor = date_format(date_create($request->dor), 'Y-m-d');
        $assignment->save();


        \Session::flash('flash_message', 'Asset Assignment successfully updated!');
        return redirect('assignment-listing');
    }


    public function doDeleteAssign($id)
    {
        $assign = AssignAsset::find($id);
        $assign->delete();

        \Session::flash('flash_message', 'Asset Assignment successfully Deleted!');
        return redirect('assignment-listing');
    }

}
