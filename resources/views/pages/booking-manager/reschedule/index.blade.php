@extends('layouts.app', [
    'title' => 'Book Reschedule',
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Get the current time using Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Calculate current time in minutes
    @endphp

    <form action="{{ route('booking-manager-update-reschedule', $datas->id) }}" method="POST">
        @csrf
        <div class="card p-4">
            <div class="row">
                <h2>
                    Reschedule {{ $datas->book_id }}
                </h2>

                <div class="col-lg-8 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="booking_date">Name</label>
                        <input type="text" value="{{ $datas->users->name }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Email</label>
                        <input type="text" value="{{ $datas->users->email }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">No Whatsapp</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text" id="basic-addon1">+62</span>
                            <input class="form-control" type="text" id="no_tlp-{{ $datas->id }}"
                                value="{{ $datas->users->no_tlp }}"
                                oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                                placeholder="82244862271" autocomplete="off" required />
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Booking Date</label>
                        <input type="text" value="{{ $datas->booking_date }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Booking Time</label>
                        <input type="text" value="{{ $datas->booking_time }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div id="booking-preview" class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-3">
                                <label for="booking_date">Select Date:</label>
                                <input type="text" id="booking_date" name="booking_date" class="form-control"
                                    autocomplete="off" required>
                            </div>

                            <div class="form-group mb-3">
                                <label for="booking_time">Select Time:</label>
                                <div id="time-slots" class="d-flex flex-wrap mb-2">
                                    <!-- Time slots will be loaded here -->
                                </div>
                                <input type="hidden" id="booking_time" name="booking_time">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Reschedule</button>
        </div>
    </form>

    @push('js-konten')
        <script>
            $(document).ready(function() {
                // Datepicker configuration
                $('#booking_date').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '0d',
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', function(e) {
                    checkDate(e.format());
                });

                function checkDate(date) {
                    $.ajax({
                        url: '{{ route('book.checkDate') }}',
                        type: 'GET',
                        data: {
                            date: date
                        },
                        success: function(response) {
                            if (response.allBooked) {
                                iziToast.info({
                                    title: 'Info',
                                    message: 'All time slots for this date are booked. Please select another date.',
                                    position: 'topCenter',
                                });

                                $('#time-slots').html(
                                    '<div class="card bg-warning text-white p-3">All time slots for this date are booked. Please select another date.</div>'
                                );
                            } else {
                                loadTimeSlots(date);
                            }
                        }
                    });
                }

                function loadTimeSlots(selectedDate) {
                    $('#time-slots').empty();

                    $.ajax({
                        url: '{{ route('book.checkTime') }}',
                        type: 'GET',
                        data: {
                            date: selectedDate
                        },
                        success: function(response) {
                            const bookedTimes = response.bookedTimes;
                            const start = 9 * 60; // 09:00

                            const end = 21 * 60; // 21:00

                            const selectedDateTime = new Date(selectedDate);
                            const currentDateTime = new Date();

                            for (let time = start; time <= end; time += 20) {
                                const hour = Math.floor(time / 60);
                                const minute = time % 60;
                                const timeString = hour.toString().padStart(2, '0') + ':' + minute
                                    .toString().padStart(2, '0');

                                const isBooked = bookedTimes.includes(timeString);
                                const isCurrent = selectedDateTime.setHours(hour, minute, 0, 0) <=
                                    currentDateTime;

                                // Add different styles for available and booked time slots
                                if (isBooked || isCurrent) {
                                    $('#time-slots').append(`
                        <button type="button" class="btn btn-outline-danger m-1 time-slot" disabled>
                            ${timeString}
                        </button>
                    `);
                                } else {
                                    $('#time-slots').append(`
                        <button type="button" class="btn btn-outline-success m-1 time-slot" data-time="${timeString}">
                            ${timeString}
                        </button>
                    `);
                                }
                            }

                            // Click handler for available time slots
                            $('.time-slot').click(function() {
                                $('#booking_time').val($(this).data('time'));
                                $('.time-slot').removeClass('btn-success').addClass(
                                    'btn-outline-success');
                                $(this).removeClass('btn-outline-success').addClass('btn-success');
                            });
                        }
                    });
                }

            });
        </script>
    @endpush
@endsection
