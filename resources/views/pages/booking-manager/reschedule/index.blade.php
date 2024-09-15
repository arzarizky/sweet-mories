@extends('layouts.app', [
    'title' => 'Book Reschedule',
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Mengambil waktu saat ini menggunakan Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Menghitung waktu sekarang dalam menit
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
                        <input type="text" value="{{ $datas->users->name }}" class="form-control"
                            autocomplete="off" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Email</label>
                        <input type="text" value="{{ $datas->users->email }}" class="form-control"
                            autocomplete="off" required readonly>
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
                        <input type="text" value="{{ $datas->booking_date }}" class="form-control"
                            autocomplete="off" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="booking_date">Booking Time</label>
                        <input type="text" value="{{ $datas->booking_time }}" class="form-control"
                            autocomplete="off" required readonly>
                    </div>
                </div>

                <div class="col-lg-4 col-sm-12">
                    <div id="#booking-preview" class="row">
                        <div class="col-md-12">

                            <div class="form-group mb-3">
                                <label for="booking_date">Select Date:</label>
                                <input type="text" id="booking_date" name="booking_date" class="form-control"
                                    autocomplete="off" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="booking_time">Select Time:</label>
                                <div id="time-slots" class="d-flex flex-wrap">
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

                // Konfigurasi Datepicker
                $('#booking_date').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '0d',
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', function(e) {
                    checkDate(e.format());
                });

                // Fungsi untuk memuat slot waktu
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

                            // Menghitung waktu saat ini pada tanggal yang dipilih
                            const selectedDateTime = new Date(selectedDate);
                            const now = new Date();
                            const currentTime = (selectedDateTime.toDateString() === now.toDateString()) ?
                                (now.getHours() * 60 + now.getMinutes()) :
                                0; // jika tanggal yang dipilih adalah hari ini, gunakan waktu sekarang

                            for (let time = start; time < end; time += 20) {
                                const hours = String(Math.floor(time / 60)).padStart(2, '0');
                                const minutes = String(time % 60).padStart(2, '0');
                                const timeString = `${hours}:${minutes}`;

                                const timeCard = $('<div class="card m-1 p-2">').text(timeString).css(
                                    'cursor', 'pointer');

                                if (bookedTimes.includes(timeString) || (selectedDateTime.toDateString() ===
                                        now.toDateString() && time < currentTime)) {
                                    timeCard.addClass('bg-danger text-white').css('cursor', 'not-allowed');
                                } else {
                                    timeCard.click(function() {
                                        $('#booking_time').val(timeString);
                                        $('#time-slots .card').removeClass('bg-success text-white');
                                        $(this).addClass('bg-success text-white');
                                    });
                                }

                                $('#time-slots').append(timeCard);
                            }
                        }
                    });
                }

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
            });
        </script>
    @endpush
@endsection
