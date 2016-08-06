<?php

namespace App\Http\Controllers;

use App\Jobs\ExportData;
use App\Models\Employee;
use App\Models\EmployeeUpload;
use App\Models\Role;
use App\User;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Maatwebsite\Excel\Facades\Excel;

class EmpController extends Controller
{
    public function addEmployee()
    {
        $roles = Role::get();
        return view('hrms.employee.add', compact('roles'));
    }

    public function processEmployee(Request $request)
    {
        $filename = public_path('photos/a.png');
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = str_random(12);
            $fileExt = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return redirect()->back()->with('message', 'Extension not allowed');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);

        }

        $user = new User;
        $user->name = $request->emp_name;
        $user->email = str_replace(' ', '_', $request->emp_name) . '@dipi-ip.com';
        $user->password = bcrypt('123456');
        $user->save();

        $emp = new Employee;
        $emp->photo = $filename;
        $emp->name = $request->emp_name;
        $emp->code = $request->emp_code;
        $emp->status = $request->emp_status;
        $emp->gender = $request->gender;
        $emp->date_of_birth = date_format(date_create($request->dob), 'Y-m-d');
        $emp->date_of_joining = date_format(date_create($request->doj), 'Y-m-d');
        $emp->number = $request->mob_number;
        $emp->qualification = $request->qualification;
        $emp->emergency_number = $request->emer_number;
        $emp->pan_number = $request->pan_number;
        $emp->father_name = $request->father_name;
        $emp->current_address = $request->address;
        $emp->permanent_address = $request->permanent_address;
        $emp->formalities = $request->formalities;
        $emp->offer_acceptance = $request->offer_acceptance;
        $emp->probation_period = $request->prob_period;
        $emp->date_of_confirmation = date_format(date_create($request->doc), 'Y-m-d');
        $emp->department = $request->department;
        $emp->salary = $request->salary;
        $emp->account_number = $request->account_number;
        $emp->bank_name = $request->bank_name;
        $emp->ifsc_code = $request->ifsc_code;
        $emp->pf_account_number = $request->pf_account_number;
        $emp->pf_status = $request->pf_status;
        $emp->date_of_resignation = $request->dor;
        $emp->notice_period = $request->notice_period;
        $emp->last_working_day = $request->last_working_day;
        $emp->full_final = $request->full_final;
        $emp->user_id = $user->id;
        $emp->save();

        $emp->userrole()->create(['role_id' => $request->role]);
        $emp->save();

        return json_encode(['title' => 'Success', 'message' => 'Employee added successfully', 'class' => 'modal-header-success']);

    }

    public function showEmployee()
    {
        $emps = User::with('employee', 'role.role')->paginate(40);
        return view('hrms.employee.show_emp', compact('emps'));
    }

    public function showEdit($id)
    {
        $emps = Employee::whereid($id)->with('userrole.role')->first();
        $roles = Role::get();
        return view('hrms.employee.add', compact('emps', 'roles'));
    }

    public function doEdit(Request $request, $id)
    {
        $filename = public_path('photos/a.png');
        if ($request->file('photo')) {
            $file = $request->file('photo');
            $filename = str_random(12);
            $fileExt = $file->getClientOriginalExtension();
            $allowedExtension = ['jpg', 'jpeg', 'png'];
            $destinationPath = public_path('photos');
            if (!in_array($fileExt, $allowedExtension)) {
                return redirect()->back()->with('message', 'Extension not allowed');
            }
            $filename = $filename . '.' . $fileExt;
            $file->move($destinationPath, $filename);

        }

        $photo = $request->$filename;
        $emp_name = $request->emp_name;
        $emp_code = $request->emp_code;
        $emp_status = $request->emp_status;
        $gender = $request->gender;
        $dob = date_format(date_create($request->dob), 'Y-m-d');
        $doj = date_format(date_create($request->doj), 'Y-m-d');
        $mob_number = $request->mob_number;
        $qualification = $request->qualification;
        $emer_number = $request->emer_number;
        $pan_number = $request->pan_number;
        $father_name = $request->father_name;
        $address = $request->address;
        $permanent_address = $request->permanent_address;
        $formalities = $request->formalities;
        $offer_acceptance = $request->offer_acceptance;
        $prob_period = $request->prob_period;
        $doc = date_format(date_create($request->doc), 'Y-m-d');
        $department = $request->department;
        $salary = $request->salary;
        $account_number = $request->account_number;
        $bank_name = $request->bank_name;
        $ifsc_code = $request->ifsc_code;
        $pf_account_number = $request->pf_account_number;
        $pf_status = $request->pf_status;
        $dor = $request->dor;
        $notice_period = $request->notice_period;
        $last_working_day = $request->last_working_day;
        $full_final = $request->full_final;

        $edit = Employee::findOrFail($id);
        if (!empty($photo)) {
            $edit->photo = $photo;
        }
        if (!empty($emp_name)) {
            $edit->emp_name = $emp_name;
        }
        if (!empty($emp_code)) {
            $edit->emp_code = $emp_code;
        }
        if (!empty($emp_status)) {
            $edit->emp_status = $emp_status;
        }
        if (!empty($gender)) {
            $edit->gender = $gender;
        }
        if (!empty($dob)) {
            $edit->dob = $dob;
        }
        if (!empty($doj)) {
            $edit->doj = $doj;
        }
        if (!empty($mob_number)) {
            $edit->mob_number = $mob_number;
        }
        if (!empty($qualification)) {
            $edit->qualification = $qualification;
        }
        if (!empty($emer_number)) {
            $edit->emer_number = $emer_number;
        }
        if (!empty($pan_number)) {
            $edit->pan_number = $pan_number;
        }
        if (!empty($father_name)) {
            $edit->father_name = $father_name;
        }
        if (!empty($address)) {
            $edit->address = $address;
        }
        if (!empty($permanent_address)) {
            $edit->permanent_address = $permanent_address;
        }
        if (!empty($formalities)) {
            $edit->formalities = $formalities;
        }
        if (!empty($offer_acceptance)) {
            $edit->offer_acceptance = $offer_acceptance;
        }
        if (!empty($prob_period)) {
            $edit->prob_period = $prob_period;
        }
        if (!empty($doc)) {
            $edit->doc = $doc;
        }
        if (!empty($department)) {
            $edit->department = $department;
        }
        if (!empty($salary)) {
            $edit->salary = $salary;
        }
        if (!empty($account_number)) {
            $edit->account_number = $account_number;
        }
        if (!empty($bank_name)) {
            $edit->bank_name = $bank_name;
        }
        if (!empty($ifsc_code)) {
            $edit->ifsc_code = $ifsc_code;
        }
        if (!empty($pf_account_number)) {
            $edit->pf_account_number = $pf_account_number;
        }
        if (!empty($pf_status)) {
            $edit->pf_status = $pf_status;
        }
        if (!empty($dor)) {
            $edit->dor = $dor;
        }
        if (!empty($notice_period)) {
            $edit->notice_period = $notice_period;
        }
        if (!empty($last_working_day)) {
            $edit->last_working_day = $last_working_day;
        }
        if (!empty($full_final)) {
            $edit->full_final = $full_final;
        }

        $edit->save();

        return json_encode(['title' => 'Success', 'message' => 'Employee details successfully updated', 'class' => 'modal-header-success']);
    }

    public function doDelete($id)
    {
        $emp = Employee::find($id);
        $emp->delete();

        \Session::flash('flash_message', 'Employee successfully Deleted!');
        return redirect()->back();
    }

    public function importFile()
    {
        return view('hrms.employee.upload');
    }

    public function uploadFile(Request $request)
    {
        $files = Input::file('upload_file');

        /* try {*/
        foreach ($files as $file) {
            Excel::load($file, function ($reader) {
                $rows = $reader->get(['emp_name', 'emp_code', 'emp_status', 'role', 'gender', 'dob', 'doj', 'mob_number', 'qualification',
                    'emer_number', 'pan_number', 'father_name', 'address', 'permanent_address', 'formalities', 'offer_acceptance',
                    'prob_period', 'doc', 'department', 'salary', 'account_number', 'bank_name', 'ifsc_code', 'pf_account_number',
                    'pf_status', 'dor', 'notice_period', 'last_working_day', 'full_final']);

                foreach ($rows as $row) {

                    $user = new User;
                    $user->name = $row->emp_name;
                    $user->email = str_replace(' ', '_', $row->emp_name) . '@dipi-ip.com';
                    $user->password = bcrypt('123456');
                    $user->save();

                    $attachment = new Employee();
                    $attachment->photo = '/img/Emp.jpg';
                    $attachment->name = $row->emp_name;
                    $attachment->code = $row->emp_code;
                    $attachment->status = convertStatus($row->emp_status);

                    if (empty($row->gender)) {
                        $attachment->gender = 'Not Exist';
                    } else {
                        $attachment->gender = $row->gender;
                    }
                    if (empty($row->dob)) {
                        $attachment->date_of_birth = '0000-00-00';
                    } else {
                        $attachment->date_of_birth = $row->dob;
                    }
                    if (empty($row->doj)) {
                        $attachment->date_of_joining = '0000-00-00';
                    } else {
                        $attachment->date_of_joining = $row->doj;
                    }
                    if (empty($row->mob_number)) {
                        $attachment->number = '1234567890';
                    } else {
                        $attachment->number = $row->mob_number;
                    }
                    if (empty($row->qualification)) {
                        $attachment->qualification = 'Not Exist';
                    } else {
                        $attachment->qualification = $row->qualification;
                    }
                    if (empty($row->emer_number)) {
                        $attachment->emergency_number = '1234567890';
                    } else {
                        $attachment->emergency_number = $row->emer_number;
                    }
                    if (empty($row->pan_number)) {
                        $attachment->pan_number = 'Not Exist';
                    } else {
                        $attachment->pan_number = $row->pan_number;
                    }
                    if (empty($row->father_name)) {
                        $attachment->father_name = 'Not Exist';
                    } else {
                        $attachment->father_name = $row->father_name;
                    }
                    if (empty($row->address)) {
                        $attachment->current_address = 'Not Exist';
                    } else {
                        $attachment->current_address = $row->address;
                    }
                    if (empty($row->permanent_address)) {
                        $attachment->permanent_address = 'Not Exist';
                    } else {
                        $attachment->permanent_address = $row->permanent_address;
                    }
                    if (empty($row->formalities)) {
                        $attachment->formalities = '1';
                    } else {
                        $attachment->formalities = $row->formalities;
                    }
                    if (empty($row->offer_acceptance)) {
                        $attachment->offer_acceptance = '1';
                    } else {
                        $attachment->offer_acceptance = $row->offer_acceptance;
                    }
                    if (empty($row->prob_period)) {
                        $attachment->probation_period = 'Not Exist';
                    } else {
                        $attachment->probation_period = $row->prob_period;
                    }
                    if (empty($row->doc)) {
                        $attachment->date_of_confirmation = '0000-00-00';
                    } else {
                        $attachment->date_of_confirmation = $row->doc;
                    }
                    if (empty($row->department)) {
                        $attachment->department = 'Not Exist';
                    } else {
                        $attachment->department = $row->department;
                    }
                    if (empty($row->salary)) {
                        $attachment->salary = '00000';
                    } else {
                        $attachment->salary = $row->salary;
                    }
                    if (empty($row->account_number)) {
                        $attachment->account_number = 'Not Exist';
                    } else {
                        $attachment->account_number = $row->account_number;
                    }
                    if (empty($row->bank_name)) {
                        $attachment->bank_name = 'Not Exist';
                    } else {
                        $attachment->bank_name = $row->bank_name;
                    }
                    if (empty($row->ifsc_code)) {
                        $attachment->ifsc_code = 'Not Exist';
                    } else {
                        $attachment->ifsc_code = $row->ifsc_code;
                    }
                    if (empty($row->pf_account_number)) {
                        $attachment->pf_account_number = 'Not Exist';
                    } else {
                        $attachment->pf_account_number = $row->pf_account_number;
                    }
                    if (empty($row->pf_status)) {
                        $attachment->pf_status = '1';
                    } else {
                        $attachment->pf_status = $row->pf_status;
                    }
                    if (empty($row->dor)) {
                        $attachment->date_of_resignation = '0000-00-00';
                    } else {
                        $attachment->date_of_resignation = $row->dor;
                    }
                    if (empty($row->notice_period)) {
                        $attachment->notice_period = 'Not exist';
                    } else {
                        $attachment->notice_period = $row->notice_period;
                    }
                    if (empty($row->last_working_day)) {
                        $attachment->last_working_day = '0000-00-00';
                    } else {
                        $attachment->last_working_day = $row->last_working_day;
                    }
                    if (empty($row->full_final)) {
                        $attachment->full_final = 'Not exist';
                    } else {
                        $attachment->full_final = $row->full_final;
                    }
                    $attachment->user_id = $user->id;
                    $attachment->save();

                    $attachment->userrole()->create(['role_id' => convertRole($row->role)]);
                }
                //return redirect('upload_form');*/
            });
        }
        /*catch (\Exception $e) {
           return $e->getMessage();*/

        \Session::flash('success', ' Employee details uploaded successfully.');
        return redirect()->back();
    }

    public function searchEmployee(Request $request)
    {
        $string = $request->string;
        $column = $request->column;
        if ($request->button == 'Search')
        {
            if($column == 'email')
            {
                $emps = User::with('employee')->where($column, $string)->paginate(20);
            }
            else
            {
                $emps = User::whereHas('employee', function ($q) use ($column, $string)
                {
                    $q->whereRaw($column . " like '%" . $string . "%'");
                })->with('employee')
                  ->paginate(20);
            }
            return view('hrms.employee.show_emp', compact('emps'));
        }
        else{
            if($column==''){
                $emps=User::with('employee')->get();
            }
            elseif($column == 'email')
            {
                $emps = User::with('employee')->where($request->column, $request->string)->paginate(20);
            }
            else
            {
                $emps = User::whereHas('employee', function ($q) use ($column, $string)
                {
                    $q->whereRaw($column . " like '%" . $string . "%'");
                })->with('employee')
                  ->get();
            }

            $results=[];
            foreach($emps as $emp)
            {
                $results['id'] = $emp->id;
                $results['name'] = $emp->name;
                $results['code'] = $emp->employee->code;
                $results['status'] = $emp->employee->status;
                $results['gender'] = ($emp->employee->gender == '0') ? 'Female' : 'Male';

            }
            Excel::create('Employee_Details', function ($excel) use ($results) {

                $excel->sheet('Employees', function ($sheet) use ($results) {

                    $sheet->fromArray($results);

                });

            })->export('xls');
            /*$job = (new ExportData($request->all(), \Auth::user(), 'employees'))->onQueue('export-employees');
            $this->dispatch($job);*/
        }
    }

    public function exportData($request)
    {
    }
}
