<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seat Reservation Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="text-center">
                <div class="mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-wide mb-2">
                        SEAT RESERVATION REPORT
                    </h1>
                    <div class="w-24 h-1 bg-white mx-auto rounded-full"></div>
                </div>

                <div class="bg-white/10 backdrop-blur-sm rounded-lg p-6 max-w-2xl mx-auto">
                    <h2 class="text-xl font-semibold mb-3 text-blue-100">Carmen Senior High School</h2>
                    <p class="text-blue-200 mb-4">Carmen, Cotabato</p>

                    <div class="grid md:grid-cols-2 gap-4 text-sm">
                        <div class="bg-white/10 rounded-lg p-3">
                            <span class="block text-blue-200 font-medium">Report Generated</span>
                            <span class="text-white font-semibold">{{ date('F j, Y') }}</span>
                        </div>
                        <div class="bg-white/10 rounded-lg p-3">
                            <span class="block text-blue-200 font-medium">Date Range</span>
                            <span class="text-white font-semibold">{{ $fromDate }} to {{ $toDate }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="max-w-6xl mx-auto px-6 py-8">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Seat Reservation Details
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Seat Number
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                User
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Reason
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Reserved At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($seat_reservation as $index => $reservation)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $index % 2 == 1 ? 'bg-gray-25' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-100">
                                {{ $reservation['space'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['user'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['reason'] ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($reservation['created_at'])->format('M j, Y g:i A') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(empty($seat_reservation) || count($seat_reservation) == 0)
            <div class="text-center py-12">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Reservations Found</h3>
                <p class="text-gray-500">No seat reservations were found for the selected date range.</p>
            </div>
            @endif
        </div>
    </main>

    <footer class="bg-gray-800 text-white mt-12">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center md:text-left">
                    <h4 class="text-lg font-semibold mb-3 text-gray-200">Carmen Senior High School</h4>
                    <p class="text-gray-400 text-sm leading-relaxed">
                        Excellence in Education<br>
                        Carmen, Cotabato<br>
                        Book and Equipment Reservation System
                    </p>
                </div>

                <div class="text-center">
                    <h4 class="text-lg font-semibold mb-3 text-gray-200">Report Information</h4>
                    <div class="space-y-2 text-sm text-gray-400">
                        <p>Generated: {{ date('F j, Y H:i:s') }}</p>
                        <p>Total Records: {{ count($seat_reservation ?? []) }}</p>
                        <p class="inline-flex items-center justify-center">
                            <svg class="w-4 h-4 mr-1 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Report Generated Successfully
                        </p>
                    </div>
                </div>

                <div class="text-center md:text-right">
                    <h4 class="text-lg font-semibold mb-3 text-gray-200">System Details</h4>
                    <div class="text-sm text-gray-400 space-y-2">
                        <p>Seat Reservation System</p>
                        <p>Version 1.0</p>
                        <p class="text-xs text-gray-500 mt-4">
                            © {{ date('Y') }} Carmen Senior High School
                        </p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-6 text-center">
                <p class="text-sm text-gray-500">
                    This report is confidential and intended for authorized personnel only.
                </p>
            </div>
        </div>
    </footer>
</body>

</html>