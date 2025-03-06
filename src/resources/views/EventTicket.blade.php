@php
    use Carbon\Carbon;

    $startDate = Carbon::parse($event->start_date)->format('D, d M Y');
    $startTime = Carbon::createFromFormat('H:i:s', $event->start_time)->format('g:i A');
    $endTime = Carbon::createFromFormat('H:i:s', $event->end_time)->format('g:i A');
    $purchaseDate = Carbon::parse($transactionDetails->created_at)->format('D, d M Y');

    $path = public_path() . '/qrCodes/' . $ticketId . '.png';
    QRCode::text($ticketId)->setOutfile($path)->png();

    $ticketQrPath = public_path('/qrCodes/' . $ticketId . '.png');

    $logoPath = public_path('/small.png');
    $logoData = file_exists($logoPath) ? file_get_contents($logoPath) : '';
    $logoBase64 = $logoData ? 'data:image/png;base64,' . base64_encode($logoData) : '';
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Event Ticket</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        #movieticket-container {
            display: flex;
            padding: 30px;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ticket-wrapper {
            width: 95%;
            border: 3px solid #3498db;
            border-radius: 10px;
            padding: 20px;
            background-color: #ffffff;
            margin: 0 auto;
        }

        /* Use table layout for the header */
        .ticket-header {
            width: 100%;
            margin-bottom: 50px;
        }

        .ticket-header table {
            width: 100%;
            border-collapse: collapse;
        }

        .ticket-header td {
            vertical-align: middle;
        }

        .logo-section {
            text-align: left;
        }

        .qr-section {
            text-align: right;
            /* border: 1.5px solid #3498db;
            border-radius: 4px;
            padding: 2px; */
            /* width: 120px; adjust as needed */
        }

        .logoName {
            width: 120px
        }

        .ticket-body {
            overflow: hidden;
            background-color: #79bbe8;
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .thumbnail {
            width: 200px;
            height: 250px;
            background-color: gray;
            border-radius: 15px;
            overflow: hidden;
            float: left;
            margin-right: 20px;
        }

        .thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .details {
            font-size: 16px;
            color: #000;
            overflow: hidden;
        }

        .details h3 {
            margin: 0 0 10px 0;
            font-size: 20px;
            font-weight: bold;
            color: #000;
        }

        .details p {
            margin: 5px 0;
        }

        .details p strong {
            width: 100px;
            display: inline-block;
        }

        .ticket-info {
            border-top: 2px dashed #3498db;
            padding-top: 40px;
            margin-bottom: 20px;
        }

        .info-block {
            border: 1px solid #3498db;
            border-radius: 10px;
            padding: 15px;
            font-size: 16px;
        }

        .info-block p {
            margin: 5px 0;
        }

        .info-block p strong {
            width: 120px;
            display: inline-block;
        }

        .terms {
            font-size: 16px;
            color: #47a2de;
            font-weight: bold;
            margin-bottom: 10px;
            margin-top: 10px;
        }

        .terms ul {
            list-style-type: disc;
            padding-left: 20px;
            font-size: 14px;
            color: #666;
            margin: 0;
        }
    </style>
</head>

<body>
    <div id="movieticket-container" style="margin-right:15px">
        <div class="ticket-wrapper">
            <div class="ticket-header">
                <table>
                    <tr>
                        <td class="logo-section">
                            <div>
                                <div style="   "> <img src="{{ $logoBase64 }}" alt="Logo" height="90" /></div>
                                <div style="float: right;   ">
                                    <h2 style="color: #47a2de; margin: 0;">FRONTROW</h2>
                                    <h5 style="color: #70aad1; margin: 0;">EVENT TICKET</h5>
                                </div>

                            </div>
                            <div>

                                {{-- <span>
                                    <h2 style="color: #47a2de; margin: 0;">FRONTROW</h2>
                                <h5 style="color: #70aad1; margin: 0;">MOVIE TICKET</h5>
                                </span> --}}

                            </div>
                        </td>
                        {{-- <td>

                        </td> --}}
                        <td class="qr-section">
                            <img src="{{ $ticketQrPath }}" alt="QR Code" style="width: 130px; height: 130px;" />
                        </td>
                    </tr>
                </table>
            </div>
            <div class="ticket-body">

                <table>
                    <td style="vertical-align: middle;">
                        <div class="thumbnail">
                            <img src="{{ $event->thumbnail_url }}" alt="Movie Thumbnail" />
                        </div>
                    </td>
                    <td style="vertical-align: middle;">
                        <div class="details">
                            <h3>{{ $event->title }}</h3>
                            <div><strong>Date:</strong> {{ $startDate }}</div>
                            <div><strong>Time:</strong> {{ $startTime }} to {{ $endTime }}</div>
                            <div><strong>Venue:</strong> {{ $event->location_name }}</div>
                        </div>
                    </td>
                </table>


            </div>
            <div class="ticket-info">
                <div class="info-block">
                    <p><strong>Ticket ID:</strong> {{ $ticketId }}</p>
                    <p><strong>Price:</strong> {{ $transactionDetails->currency }} {{ $transactionDetails->amount }}
                    </p>
                    <p><strong>Purchase Date:</strong> {{ $purchaseDate }}</p>
                </div>
            </div>
            <div class="terms">Terms & Conditions:</div>
            <ul>
                <li>This ticket is valid only for the specified show time and date.</li>
                <li>Please arrive at least 15 minutes before show time.</li>
                <li>No refunds or exchanges are permitted.</li>
                <li>Please keep this ticket safe and present it at the entrance.</li>
            </ul>
        </div>
    </div>
</body>

</html>
