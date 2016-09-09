<?php

  namespace App\Http\Controllers;

  use App\Models\Event;
  use App\Models\EventAttendee;
  use App\Models\Meeting;
  use App\Models\MeetingAttendee;
  use App\User;
  use Illuminate\Http\Request;

  use App\Http\Requests;
  use Illuminate\Support\Facades\Mail;

  class EventController extends Controller {

    public function index()
    {

      $leaders = User::whereHas('role', function ($q)
      {
        $q->whereIn('role_id', ['1', '2', '5', '7', '14', '16']);
      })->get();

      $coordinators = [];

      foreach($leaders as $leader)
      {
        $coordinators[] = ['id' => $leader->id, 'name' => $leader->name];
      }

      $users = User::get(['id', 'name']);

      return view('hrms.events.index', compact('coordinators', 'users'));
    }

    public function createEvent(Request $request)
    {

      $name = $request->name;
      $coordinator = $request->coordinator;
      $attendees = $request->attendees;
        $date = date_format(date_create($request->date), 'Y-m-d H:i');
      $message = $request->message;

      $event = new Event();
      $event->name = $name;
      $event->coordinator_id = $coordinator;
      $event->date = $date;
      $event->message = $message;
      $event->save();

      $coordinator = User::where('id', $coordinator)->first();

      foreach($attendees as $attendee)
      {
        $eventAttendee = new EventAttendee();
        $eventAttendee->event_id = $event->id;
        $eventAttendee->attendee_id = $attendee;
        $eventAttendee->save();

        //now we will send an email to each attendee about this event
        $user = User::where('id', $attendee)->first();

        $data = ['name' => $name, 'coordinator' => $coordinator->name, 'date' => $date, 'attendee_name' => $user->name];

        Mail::send('emails.event', ['data' => $data], function($message) use($user, $coordinator)
        {
          $message->from($coordinator->email, $coordinator->name);
          $message->to($user->email, $user->name)->subject($coordinator->name .' has invited you to an event');
        });
      }

      return json_encode('success');

    }

    public function meeting()
    {
        $leaders = User::whereHas('role', function ($q)
        {
            $q->whereIn('role_id', ['1', '2', '5', '7', '14', '16']);
        })->get();

        $coordinators = [];

        foreach($leaders as $leader)
        {
            $coordinators[] = ['id' => $leader->id, 'name' => $leader->name];
        }

        $users = User::get(['id', 'name']);

        return view('hrms.meeting.meeting_index', compact('coordinators', 'users'));
    }

    public function createMeeting(Request $request)
    {

        $name = $request->name;
        $coordinator = $request->coordinator;
        $attendees = $request->attendees;
        $date = $request->date;
        $message = $request->message;

        $meeting = new Meeting();
        $meeting->name = $name;
        $meeting->coordinator_id = $coordinator;
        $meeting->date = $date;
        $meeting->message = $message;
        $meeting->save();

        $coordinator = User::where('id', $coordinator)->first();

        foreach($attendees as $attendee)
        {
            $meetingAttendee = new MeetingAttendee();
            $meetingAttendee->meeting_id = $meeting->id;
            $meetingAttendee->attendee_id = $attendee;
            $meetingAttendee->save();

            //now we will send an email to each attendee about this event
            $user = User::where('id', $attendee)->first();

            $data = ['name' => $name, 'coordinator' => $coordinator->name, 'date' => $date, 'attendee_name' => $user->name];

            Mail::send('emails.meeting', ['data' => $data], function($message) use($user, $coordinator)
            {
                $message->from($coordinator->email, $coordinator->name);
                $message->to($user->email, $user->name)->subject($coordinator->name .' has invited you to a meeting');
            });
        }

        return json_encode('success');

    }

      /**
       * @return string
       */

  }
