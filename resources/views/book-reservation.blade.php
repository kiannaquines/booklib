<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Reservation Report</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-900 min-h-screen">
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="text-center">
                <div class="mb-4">
                    <h1 class="text-3xl md:text-4xl font-bold tracking-wide mb-2">
                        BOOK RESERVATION REPORT
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
                            <span class="block text-blue-200 font-medium">Date Range & Status</span>
                            <span class="text-white font-semibold">{{ $fromDate }} to {{ $toDate }}</span>
                            <span class="block text-blue-100 text-xs mt-1">Status: {{ $status }}</span>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Reservation Details
                </h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Book
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Student
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Study Space
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Start Time
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                End Time
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Status
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase tracking-wider border-b border-gray-200">
                                Created At
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($book_reservations as $index => $reservation)
                        <tr class="hover:bg-gray-50 transition-colors duration-150 {{ $index % 2 == 1 ? 'bg-gray-25' : '' }}">
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-100">
                                {{ $reservation['book'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['user'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['study_space'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['start_time'] }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700 border-r border-gray-100">
                                {{ $reservation['end_time'] }}
                            </td>
                            <td class="px-6 py-4 text-sm border-r border-gray-100">
                                <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full">
                                    {{ $reservation['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $reservation['created_at'] }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                        <p>Total Records: {{ count($book_reservations ?? []) }}</p>
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
                        <p>Book and Equipment Reservation System</p>
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