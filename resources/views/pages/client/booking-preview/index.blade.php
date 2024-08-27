@extends('layouts.app', [
    'title' => 'Booking Preview ' . $users->name,
])

@section('konten')
    <div id="#booking-preview" class="row">
        <div class="col-md-12">
            <div class="container">
                <div class="card">
                    <div class="card-body">
                        <h3 class="card-title text-center">Pilih Tanggal dan Waktu</h3>

                        <!-- Tanggal -->
                        <div class="mb-3">
                            <label for="bookingDate" class="form-label">Pilih Tanggal:</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class="bx bx-calendar"></i>
                                </span>
                                <input type="date" id="bookingDate" class="form-control" min="">
                            </div>
                        </div>

                        <!-- Waktu -->
                        <div class="mb-3">
                            <label class="form-label">Pilih Waktu:</label>
                            <div class="times-container" id="timesContainer">
                                <!-- Cards will be generated here by JavaScript -->
                            </div>
                        </div>

                        <button class="btn btn-primary w-100" onclick="submitBooking()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('css-konten')
    <style>
        .input-group-text {
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        .input-group .form-control {
            border-left: 0;
        }

        .container {
            margin-top: 50px;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .time-card {
            cursor: pointer;
            text-align: center;
            margin: 10px;
            border: 1px solid #ced4da;
            transition: background-color 0.3s, color 0.3s;
            padding: 15px;
            border-radius: 10px;
            flex: 1 0 21%;
            /* 4 cards per row, with some margin */
            box-sizing: border-box;
        }

        .time-card:hover {
            background-color: #007bff;
            color: white;
        }

        .time-card.active {
            background-color: #007bff;
            color: white;
        }

        .time-card.disabled {
            background-color: #e9ecef;
            color: #6c757d;
            cursor: not-allowed;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .form-label {
            font-weight: bold;
        }

        .times-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            visibility: hidden;
            /* Hide times container initially */
        }

        .times-container.show {
            visibility: visible;
            /* Show times container when date is selected */
        }
    </style>
@endpush

@push('js-konten')
    <script>
        $(document).ready(function() {
            const today = new Date().toISOString().split('T')[0];
            $('#bookingDate').attr('min', today);

            // Generate time slots
            generateTimeSlots();

            // Function to generate time slots
            function generateTimeSlots() {
                const startTime = 9; // 09:00
                const endTime = 21; // 21:00
                const interval = 15; // 15 minutes

                let times = [];
                for (let hour = startTime; hour < endTime; hour++) {
                    for (let minutes = 0; minutes < 60; minutes += interval) {
                        let time = ('0' + hour).slice(-2) + ':' + ('0' + minutes).slice(-2);
                        times.push(time);
                    }
                }

                const timesContainer = $('#timesContainer');
                times.forEach(time => {
                    timesContainer.append(`<div class="time-card" data-time="${time}">${time}</div>`);
                });

                // Add click event to time cards
                $('.time-card').on('click', function() {
                    if ($(this).hasClass('disabled')) return;
                    $('.time-card').removeClass('active');
                    $(this).addClass('active');
                });

                // Fetch available dates when page loads
                fetchAvailableDates();

                // Fetch available times when date is selected
                $('#bookingDate').on('change', function() {
                    fetchAvailableTimes();
                });
            }

            // Function to fetch available dates
            function fetchAvailableDates() {
                $.ajax({
                    url: '/available-dates',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        const availableDates = response.availableDates;
                        $('#bookingDate').attr('min', availableDates[0] || today);
                    }
                });
            }

            // Function to fetch available times
            function fetchAvailableTimes() {
                const selectedDate = $('#bookingDate').val();

                if (!selectedDate) return;

                $.ajax({
                    url: '/available-times',
                    method: 'POST',
                    data: {
                        date: selectedDate,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        const availableTimes = response.availableTimes;
                        console.log(availableTimes);
                        $('.time-card').each(function() {
                            const time = $(this).data('time') + ":00";
                            console.log(time);
                            if (availableTimes.includes(time)) {
                                $(this).removeClass('disabled');
                            } else {
                                $(this).addClass('disabled');
                                $(this).removeClass('active');
                            }
                        });

                        // Show times container only if there are available times
                        $('#timesContainer').toggleClass('show', availableTimes.length > 0);
                    }
                });
            }

            // Function to handle booking submission
            function submitBooking() {
                const selectedDate = $('#bookingDate').val();
                const selectedTime = $('.time-card.active').data('time');

                if (!selectedDate || !selectedTime) {
                    alert('Harap pilih tanggal dan waktu!');
                    return;
                }

                $.ajax({
                    url: '/bookings',
                    method: 'POST',
                    data: {
                        booking_date: selectedDate,
                        booking_time: selectedTime,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        if (response.success) {
                            $('#bookingDate').val('');
                            $('.time-card').removeClass('active');
                            $('#timesContainer').removeClass('show');
                        }
                    }
                });
            }
        });
    </script>
@endpush
