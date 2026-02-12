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
use App\Models\UserWallet;
use App\Mail\EventCreationAdminMail;
use App\Mail\EventCreationOriginatorMail;
use Illuminate\Support\Facades\Mail;
use App\Models\EventTicketCategory;
use App\Models\SeatsConfig;
use App\Models\SeatMapConfigTable;
use App\Models\EventTicket;
use App\Http\Requests\AdminCreateEventTicket;
use Illuminate\Support\Facades\Cache;




class EventsController extends Controller
{


    public function homeEvents(Request $request)
    {
        $events = Event::where('is_active', true)->where('end_date', '>=', now())
            ->select('id', 'title', 'thumbnail_url', 'banner_image_url', 'start_date', 'end_date', 'location_name', 'access_type', 'created_at')
            ->with(["eventTickets:id,event_id,category,price,currency"])
            ->orderBy('created_at', 'desc')->paginate(6);
        $categories = Cache::remember('event_categories', 3600, function () {
            return EventCategory::select('id', 'name')->get();
        });

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
        $user = Auth::user();
        $isAdmin = $user->getAllPermissions()->pluck('name')->intersect(['admin', 's_admin'])->isNotEmpty();

        $query = Event::query()->latest();
        if (!$isAdmin) {
            $query->where('beneficiary_id', $user->id);
        }

        $myEvents = $query->paginate(6);
        return \Inertia\Inertia::render('Events/MyEvents', [
            'myEvents' => $myEvents
        ]);
    }

    public function ScheduleEvent(Request $request)
    {
        $eventCategories = Cache::remember('event_categories', 3600, function () {
            return EventCategory::select('id', 'name')->get();
        });
        $eventTicketCategories = Cache::remember('event_ticket_categories', 3600, function () {
            return EventTicketCategory::select('name')->get()->toArray();
        });
        $beneficiaries = User::select('id', 'name')->where('user_type', 'beneficiary')->where('beneficiary_status', 'active')->get();

        return \Inertia\Inertia::render('Events/ScheduleEvent', [
            "eventCategories" => $eventCategories,
            "beneficiaries" => $beneficiaries,
            "eventTicketCategories" => $eventTicketCategories
        ]);
    }
    public function CreateEvent(CreateEvent $request)
    {
        $eventDetails = $request->validated();
        EventService::creteEvent($eventDetails);

        $admins = User::permission('admin')->get();
        $currentUser =  User::where('id', Auth::user()->id)->first();

        foreach ($admins as $admin) {
            try {
                $message = (new EventCreationAdminMail($admin->name))
                    ->onQueue('emails');

                Mail::to($admin->email)
                    ->queue($message);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }

        try {
            $message = (new EventCreationOriginatorMail($currentUser->name))
                ->onQueue('emails');

            Mail::to($currentUser->email)
                ->queue($message);
        } catch (\Throwable $th) {
            //throw $th;
        }

        return \Inertia\Inertia::render('Events/MyEvents');
    }

    public function eventDetail(Request $request)
    {
        $eventDetail = Event::where('id', $request->id)->with([
            'beneficiary:id,name',
            'categories:id,name',
            'reviews' => function ($q) {
                $q->with('user:id,name')->latest()->limit(20);
            },
            'eventTickets:id,event_id,category,price,available_quantity,currency',
        ])->first();
        $myWallet = UserWallet::where('user_id', Auth::user()->id)->first();



        return \Inertia\Inertia::render('Events/EventDetailsPage', [
            'eventDetails' => $eventDetail,
            'myWallet' => $myWallet
        ]);
    }
    public function eventDetailHome(Request $request)
    {
        $eventDetail = Event::where('id', $request->id)->with([
            'beneficiary:id,name',
            'categories:id,name',
            'reviews' => function ($q) {
                $q->with('user:id,name')->latest()->limit(20);
            },
            'eventTickets:id,event_id,category,price,available_quantity,currency',
        ])->first();


        return \Inertia\Inertia::render('Events/EventDetailsHomePage', [
            'eventDetails' => $eventDetail,

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
        $eventId = $request->id;
        $attendanceList = EventAttendee::where('event_id', $eventId)->where('reg_status', 'approved')->with(['user:id,name,email'])->paginate(15);
        $attendanceRequests = EventAttendee::where('event_id', $eventId)->where('reg_status', 'pending')->with(['user:id,name,email'])->paginate(15);
        $declinedRequests = EventAttendee::where('event_id', $eventId)->where('reg_status', 'declined')->with(['user:id,name,email'])->paginate(15);
        $eventDetails = Event::select('id', 'access_type', 'title')->where('id', $eventId)->first();
        $eventTickets = UserEventTicket::where('event_id', $eventId)->with([
            "event:id,title,banner_image_url,location_name,start_date,end_date,start_time,end_time",
            "userPaymentDetail:id,payment_type,full_name,user_email,user_phone_number",
            "paymentTransaction:id,txn_ref,txn_status,amount,currency,created_at",
            "eventTicket:id,event_id,category,price,currency"
        ])->orderBy('created_at', 'desc')->paginate(6);
        return \Inertia\Inertia::render('Events/EventManager', [
            'attendanceList' => $attendanceList,
            'attendanceRequests' => $attendanceRequests,
            'declinedRequests' => $declinedRequests,
            'event_id' => $eventDetails->id,
            'event_type' => $eventDetails->access_type,
            'event_title' => $eventDetails->title,
            'eventTickets' => $eventTickets
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
        $events = Event::where('is_active', true)->where('end_date', '>=', now())->with(["eventTickets"])->orderBy('created_at', 'desc')->paginate(6);
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

    public function walletPay(Request $details)
    {
        EventService::payWithWallet($details);
    }

    public function saveSeatsConfig(Request $request)
    {

        $seatMap = SeatMapConfigTable::create([
            'theatre' => $request->theatreName,
            'room' => $request->room,
        ]);

        foreach ($request->seats as $seat) {
            SeatsConfig::create([
                'seat_map_config_tables_id' => $seatMap->id,
                'row' => $seat['row'],
                'seat_count' => $seat['seatCount'],
            ]);
        }
    }

    public function deleteSeatsConfig(Request $request)
    {
        $seatMap = SeatMapConfigTable::where('id', $request->seatIndex)->first();
        $seatMap->delete();
    }

    public function ticketScannerPage(Request $request)
    {
        $eventDetails = null;
        if ($request->id) {
            $eventDetails = Event::select('id', 'title', 'start_date', 'end_date', 'start_time', 'end_time', 'location_name')
                ->where('id', $request->id)
                ->first();
        }

        return \Inertia\Inertia::render('Events/TicketScanner', [
            'eventDetails' => $eventDetails,
            'event_id' => $request->id,
        ]);
    }

    public function scanTicketLookup(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string',
        ]);

        $ticket = UserEventTicket::where('ticket_id', $request->ticket_id)
            ->with([
                'event',
                'eventTicket',
                'userPaymentDetail',
                'paymentTransaction',
            ])
            ->first();

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found. This ticket ID does not exist in our system.',
                'ticket' => null,
            ], 404);
        }

        if ($request->has('event_id') && $request->event_id && $ticket->event_id != $request->event_id) {
            return response()->json([
                'status' => 'error',
                'message' => 'This ticket does not belong to this event.',
                'ticket' => null,
            ], 422);
        }

        $eventEnded = false;
        if ($ticket->event) {
            $endDateTime = \Carbon\Carbon::parse(
                $ticket->event->end_date . ' ' . $ticket->event->end_time
            );
            $eventEnded = now()->isAfter($endDateTime);
        }

        return response()->json([
            'status' => 'success',
            'ticket' => $ticket,
            'is_already_scanned' => $ticket->is_scanned,
            'scanned_at' => $ticket->scanned_at,
            'event_ended' => $eventEnded,
        ]);
    }

    public function markTicketScanned(Request $request)
    {
        $request->validate([
            'ticket_id' => 'required|string',
        ]);

        $ticket = UserEventTicket::where('ticket_id', $request->ticket_id)->first();

        if (!$ticket) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ticket not found.',
            ], 404);
        }

        if ($ticket->is_scanned) {
            return response()->json([
                'status' => 'already_scanned',
                'message' => 'This ticket has already been scanned.',
                'scanned_at' => $ticket->scanned_at,
            ], 409);
        }

        $ticket->update([
            'is_scanned' => true,
            'scanned_at' => now(),
            'scanned_by' => Auth::id(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Ticket successfully marked as scanned.',
            'ticket' => $ticket->fresh()->load(['event', 'eventTicket', 'userPaymentDetail']),
        ]);
    }

    // ---- Admin Create Ticket Wizard ----

    public function adminCreateTicketPage()
    {
        $events = Event::where('is_active', true)
            ->select('id', 'title', 'start_date', 'end_date', 'start_time', 'end_time', 'location_name', 'access_type', 'currency')
            ->with(['eventTickets:id,event_id,category,price,available_quantity,currency'])
            ->orderBy('start_date', 'desc')
            ->limit(50)
            ->get();

        return \Inertia\Inertia::render('Events/AdminCreateTicket', [
            'events' => $events,
        ]);
    }

    public function adminCreateTicket(AdminCreateEventTicket $request)
    {
        $result = EventService::adminCreateTicket($request->validated());

        $ticketData = collect($result['tickets'])->map(fn($t) => [
            'id' => $t->id,
            'ticket_id' => $t->ticket_id,
        ]);

        $events = Event::where('is_active', true)
            ->select('id', 'title', 'start_date', 'end_date', 'start_time', 'end_time', 'location_name', 'access_type', 'currency')
            ->with(['eventTickets:id,event_id,category,price,available_quantity,currency'])
            ->orderBy('start_date', 'desc')
            ->get();

        $event = Event::select('id', 'title')->find($request->event_id);

        return \Inertia\Inertia::render('Events/AdminCreateTicket', [
            'events' => $events,
            'createdTickets' => $ticketData,
            'createdEventId' => $request->event_id,
            'createdEventTitle' => $event ? $event->title : '',
            'isNewUser' => $result['is_new_user'],
            'userName' => $result['user']->name,
        ]);
    }

    public function adminSearchUser(Request $request)
    {
        $query = $request->input('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $users = User::where('email', 'ILIKE', "%{$query}%")
            ->orWhere('phone_number', 'ILIKE', "%{$query}%")
            ->orWhere('name', 'ILIKE', "%{$query}%")
            ->select('id', 'name', 'email', 'phone_number')
            ->limit(10)
            ->get();

        return response()->json($users);
    }

    public function adminEventTicketTypes($id)
    {
        $ticketTypes = EventTicket::where('event_id', $id)
            ->select('id', 'event_id', 'category', 'price', 'available_quantity', 'currency')
            ->get();

        return response()->json($ticketTypes);
    }
}