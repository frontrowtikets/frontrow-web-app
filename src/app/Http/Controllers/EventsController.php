<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\EventSettings;
use App\Services\EventService;
use App\Models\EventCategory;
use App\Models\User;
use App\Http\Requests\CreateEvent;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CreateEventReview;
use App\Http\Requests\RegisterForEvent;
use App\Models\UserEventTicket;
use App\Models\PaymentTransaction;
use App\Models\UserPaymentDetail;
use App\Models\EventAttendee;



class EventsController extends Controller
{


    public function homeEvents(Request $request)
    {
        $events = Event::where('is_active', true)->with(["eventTickets"])->orderBy('created_at', 'desc')->paginate(6);
        $categories = EventCategory::get();

        return \Inertia\Inertia::render(
            'Events/EventsHomePage',
            [
                'events' => $events,
                'categories' => $categories
            ]
        );
    }

    public function myEvents(Request $request)
    {
        $myEvents = Event::where('beneficiary_id', Auth::id())->latest()->paginate(6);
        return \Inertia\Inertia::render('Events/MyEvents', [
            'myEvents' => $myEvents
        ]);
    }

    public function ScheduleEvent(Request $request)
    {
        $eventCategories = EventCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();

        return \Inertia\Inertia::render('Events/ScheduleEvent', [
            "eventCategories" => $eventCategories,
            "beneficiaries" => $beneficiaries,
        ]);
    }
    public function CreateEvent(CreateEvent $request)
    {
        $eventDetails = $request->validated();
        EventService::creteEvent($eventDetails);
        return \Inertia\Inertia::render('Events/MyEvents');
    }

    public function eventDetail(Request $request)
    {
        $eventDetail = Event::where('id', $request->id)->with([
            'beneficiary',
            'categories',
            'reviews.user',
            'eventTickets',
        ])->first();
        return \Inertia\Inertia::render('Events/EventDetailsPage', [
            'eventDetails' => $eventDetail
        ]);
    }
    public function eventDetailHome(Request $request)
    {
        $eventDetail = Event::where('id', $request->id)->with([
            'beneficiary',
            'categories',
            'reviews.user',
            'eventTickets',
        ])->first();
        return \Inertia\Inertia::render('Events/EventDetailsHomePage', [
            'eventDetails' => $eventDetail
        ]);
    }

    public function CreateEventReview(CreateEventReview $request)
    {
        $reviewDetails = $request->validated();
        EventService::createReview($reviewDetails);
    }

    public function RegisterForEvent(RegisterForEvent $request)
    {

        $requestDetails = $request->validated();
        EventService::registerForEvent($requestDetails);
    }

    public function eventManager(Request $request)
    {
        $attendanceList = EventAttendee::where('event_id', $request->id)->where('reg_status', 'approved')->with(['user'])->paginate(15);
        $attendanceRequests = EventAttendee::where('event_id', $request->id)->where('reg_status', 'pending')->with(['user'])->paginate(15);
        $declinedRequests = EventAttendee::where('event_id', $request->id)->where('reg_status', 'declined')->with(['user'])->paginate(15);
        $eventDetails = Event::select('id', 'access_type', 'title')->where('id', $request->id)->first();
        return \Inertia\Inertia::render('Events/EventManager', [
            'attendanceList' => $attendanceList,
            'attendanceRequests' => $attendanceRequests,
            'declinedRequests' => $declinedRequests,
            'event_id' => $eventDetails->id,
            'event_type' => $eventDetails->access_type,
            'event_title' => $eventDetails->title
        ]);
    }

    public function acceptInvitation(Request $request)
    {
        EventService::approveInvitation($request);
    }

    public function declineInvitation(Request $request)
    {
        EventService::declineInvitation($request);
    }
    public function allEvents(Request $request)
    {
        $events = Event::where('is_active', true)->with(["eventTickets"])->orderBy('created_at', 'desc')->paginate(6);
        return \Inertia\Inertia::render('Events/AllEventsPage', [
            'events' => $events
        ]);
    }

    public function saveEventsSettings(EventSettings $request)
    {
        $settingsData = $request->validated();
        EventService::saveSettings($settingsData);
    }

    public function verifyTicket(Request $request)
    {
        $eventTikectDetails = UserEventTicket::where('ticket_id', $request->ticketId)->where('user_payment_detail_id', $request->userDetailsId)->where('payment_transaction_id', $request->transactionId)->with([
            'event',
        ])->first();
        $userDetails = UserPaymentDetail::where('id', $request->userDetailsId)->first();
        $transactionDetails = PaymentTransaction::where('id', $request->transactionId)->first();

        $isValid = !is_null($eventTikectDetails) && !is_null($userDetails) && !is_null($transactionDetails);

        return \Inertia\Inertia::render('Events/VerifyEventTicket', [
            'eventTikectDetails' => $eventTikectDetails,
            'userDetails' => $userDetails,
            'transactionDetails' => $transactionDetails,
            'isValid' => $isValid

        ]);
    }
    public function editEvent(Request $request)
    {
        $eventDetail = Event::where('id', $request->id)->with([
            'beneficiary',
            'categories',
            'reviews.user',
            'eventTickets',
        ])->first();
        $eventCategories = EventCategory::select('id', 'name')->get();
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();

        return \Inertia\Inertia::render('Events/ScheduleEvent', [
            "eventCategories" => $eventCategories,
            "beneficiaries" => $beneficiaries,
            "editDetails" => $eventDetail
        ]);
    }

    public function deleteEvent(Request $request)
    {
        $event = Event::where('id', $request->id)->first();
        $event->delete();
    }
}
