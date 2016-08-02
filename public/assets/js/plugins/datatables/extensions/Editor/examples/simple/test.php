<?php
    // DataTables PHP library
    include( "../../php/DataTables.php" );
     
    // Alias Editor classes so they are easy to use
    use
        DataTables\Editor,
        DataTables\Editor\Field,
        DataTables\Editor\Format,
        DataTables\Editor\Join,
        DataTables\Editor\Validate;
 
    //--- Outsource version of Editor ---//
    if ( false ) { //--- Outsource user with his/her assigned group ---//
        $data = Editor::inst($db, 'TestRequestActualSchedule', 'TestRequestNo')
            ->field(
                Field::inst('TestRequestActualSchedule.TestRequestNo')->set(false),
                Field::inst('TestRequestMain.POnumber')->set(false),
                Field::inst('TestRequestMain.ProjectName')->set(false),
 
                    Field::inst('TestEnvironment.Name')->set(false),
                Field::inst('TestRequestActualSchedule.ActualDate'),
                Field::inst('TestRequestActualSchedule.ManHrsNM')->validator('Validate::numeric'),
                Field::inst('TestRequestActualSchedule.ManHrsOT')->validator('Validate::numeric'),
                Field::inst('TestRequestActualSchedule.ManHrsOTSunPH')->validator('Validate::numeric'),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsNM')->set(false),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsOT')->set(false),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsOTSunPH')->set(false),
                Field::inst('TestRequestMain.Status'),
                    Field::inst('StatusMirror.String')->set(false),
                Field::inst('TestRequestActualSchedule.RazerApproval')->set(false),
                    Field::inst('RazerConfirmationMirror.String')->set(false),
                Field::inst('TestRequestAdv.RemarksRazer')->set(false),
                Field::inst('TestRequestMain.AssignedGroupID')->set(false),
                    Field::inst('AssignedGroup.Name')->set(false),
                Field::inst('TestRequestMain.SWQAEngineerID')->set(false)
            )
        ->leftJoin('TestRequestPlannedSchedule', 'TestRequestPlannedSchedule.TestRequestNo', '=', 'TestRequestActualSchedule.TestRequestNo')
        ->leftJoin('TestRequestAdv', 'TestRequestActualSchedule.TestRequestNo', '=', 'TestRequestAdv.TestRequestNo')
        ->leftJoin('TestRequestMain', 'TestRequestActualSchedule.TestRequestNo', '=', 'TestRequestMain.TestRequestNo')
        ->leftJoin('RazerConfirmationMirror', 'TestRequestActualSchedule.RazerApproval', '=', 'RazerConfirmationMirror.ID')
        ->leftJoin('StatusMirror', 'TestRequestMain.Status', '=', 'StatusMirror.ID')
        ->leftJoin('AssignedGroup', 'TestRequestMain.AssignedGroupID', '=', 'AssignedGroup.ID')
        ->leftJoin('TestEnvironment', 'TestEnvironment.ID', '=', 'TestRequestAdv.TestEnvironmentID')
        ->process($_POST)
        ->data();
 
        //--- Initialization of dropdown: Outsource  ---//
        if ( !isset($_POST['action']) ) {
            $data['StatusMirror'] = $db
                ->selectDistinct('StatusMirror', 'ID as value, String as label')
                ->fetchAll();
        }
    }
    //--- Outsource version of Internal Staff ---//
    else {
        $data = Editor::inst($db, 'TestRequestActualSchedule', 'TestRequestNo')
            ->field(
                Field::inst('TestRequestActualSchedule.TestRequestNo')->set(false),
                Field::inst('TestRequestMain.POnumber')->set(false),
                Field::inst('TestRequestMain.ProjectName')->set(false),
                Field::inst('TestEnvironment.Name')->set(false),
                Field::inst('TestRequestActualSchedule.ActualDate'),
                Field::inst('TestRequestActualSchedule.ManHrsNM')->validator('Validate::numeric'),
                Field::inst('TestRequestActualSchedule.ManHrsOT')->validator('Validate::numeric'),
                Field::inst('TestRequestActualSchedule.ManHrsOTSunPH')->validator('Validate::numeric'),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsNM')->set(false),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsOT')->set(false),
                Field::inst('TestRequestPlannedSchedule.ScheduledManHrsOTSunPH')->set(false),
                Field::inst('TestRequestMain.Status'),
                Field::inst('StatusMirror.String')->set(false),
                Field::inst('TestRequestActualSchedule.RazerApproval'),
                Field::inst('RazerConfirmationMirror.String')->set(false),
                Field::inst('TestRequestAdv.RemarksRazer'),
                Field::inst('TestRequestMain.AssignedGroupID')->set(false),
                Field::inst('AssignedGroup.Name')->set(false),
                Field::inst('TestRequestMain.SWQAEngineerID')->set(false)
            )
        ->leftJoin('TestRequestPlannedSchedule', 'TestRequestPlannedSchedule.TestRequestNo', '=', 'TestRequestActualSchedule.TestRequestNo')
        ->leftJoin('TestRequestAdv', 'TestRequestActualSchedule.TestRequestNo', '=', 'TestRequestAdv.TestRequestNo')
        ->leftJoin('TestRequestMain', 'TestRequestActualSchedule.TestRequestNo', '=', 'TestRequestMain.TestRequestNo')
        ->leftJoin('RazerConfirmationMirror', 'TestRequestActualSchedule.RazerApproval', '=', 'RazerConfirmationMirror.ID')
        ->leftJoin('StatusMirror', 'TestRequestMain.Status', '=', 'StatusMirror.ID')
        ->leftJoin('AssignedGroup', 'TestRequestMain.AssignedGroupID', '=', 'AssignedGroup.ID')
        ->leftJoin('TestEnvironment', 'TestEnvironment.ID', '=', 'TestRequestAdv.TestEnvironmentID')
        ->process($_POST)
        ->data();
 
        //--- Initialization of dropdown: Internal staff ---//
        if ( !isset($_POST['action']) ) {
            $data['RazerConfirmationMirror'] = $db
                ->selectDistinct('RazerConfirmationMirror', 'ID as value, String as label')
                ->fetchAll();
            $data['StatusMirror'] = $db
                ->selectDistinct('StatusMirror', 'ID as value, String as label')
                ->fetchAll();
        }
    }
 
    // Send it back to the client
    echo json_encode($data);