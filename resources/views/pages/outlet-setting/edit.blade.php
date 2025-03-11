@extends('layouts.app', [
    'title' => 'Book Reschedule',
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Get the current time using Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Calculate current time in minutes
    @endphp

    <form action="{{ route('update-setting-outlet', $datas->id) }}" method="POST">
        @csrf
        <div class="card p-4">
            <div class="row">
                <h2>
                    Update Jadwal Tutup {{ $datas->name }}
                </h2>

                <div class="form-group mb-3">
                    <label for="booking_date">Name</label>
                    <input type="text" value="{{ $datas->name }}" class="form-control" autocomplete="off" required>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="start_day_read">Mulai Tanggal Tutup</label>
                        <input type="text" value="{{ $datas->start_day }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="start_time_read">Mulai Pukul Tutup</label>
                        <input type="text" value="{{ $datas->start_time }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="end_day_read">Selesai Tanggal Tutup</label>
                        <input type="text" value="{{ $datas->end_day }}" class="form-control" autocomplete="off" required
                            readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="end_time_read">Selesai Pukul Tutup</label>
                        <input type="text" value="{{ $datas->end_time }}" class="form-control" autocomplete="off"
                            required readonly>
                    </div>
                </div>

                <div>

                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="start_day">Pilih Tanggal Mulai Tutup:</label>
                        <input type="text" id="start_day" name="start_day" class="form-control" autocomplete="off"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="start_time">Pilih Waktu Mulai Tutup:</label>
                        <div id="start-time-slots" class="d-flex flex-wrap mb-2"></div>
                        <input type="hidden" id="start_time" name="start_time" required>
                    </div>
                </div>

                <div class="col-lg-6 col-sm-12">
                    <div class="form-group mb-3">
                        <label for="end_day">Pilih Tanggal Selesai Tutup:</label>
                        <input type="text" id="end_day" name="end_day" class="form-control" autocomplete="off"
                            required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="end_time">Pilih Waktu Selesai Tutup:</label>
                        <div id="end-time-slots" class="d-flex flex-wrap mb-2"></div>
                        <input type="hidden" id="end_time" name="end_time" required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary mt-3">Update Jadwal Tutup {{ $datas->name }}</button>
        </div>
    </form>

    @push('js-konten')
        <script>
            $(document).ready(function() {

                // Konfigurasi datepicker
                $('#start_day, #end_day').datepicker({
                    format: 'yyyy-mm-dd',
                    startDate: '0d',
                    autoclose: true,
                    todayHighlight: true,
                }).on('changeDate', function(e) {
                    let type = $(this).attr('id') === 'start_day' ? 'start' : 'end';
                    checkDate(e.format(), type);
                });

                function checkDate(date, type) {
                    $.ajax({
                        url: '{{ route('book.checkDate') }}',
                        type: 'GET',
                        data: {
                            date: date
                        },
                        success: function(response) {
                            let slotContainer = type === 'start' ? '#start-time-slots' : '#end-time-slots';

                            if (response.allBooked) {
                                iziToast.info({
                                    title: 'Info',
                                    message: 'Semua slot untuk tanggal ini sudah penuh. Silakan pilih tanggal lain.',
                                    position: 'topCenter',
                                });
                                $(slotContainer).html(
                                    '<div class="card bg-warning text-white p-3">Semua slot sudah penuh. Silakan pilih tanggal lain.</div>'
                                );
                            } else {
                                loadTimeSlots(date, type);
                            }
                        }
                    });
                }

                function loadTimeSlots(selectedDate, type) {
                    let slotContainer = type === 'start' ? '#start-time-slots' : '#end-time-slots';
                    let inputField = type === 'start' ? '#start_time' : '#end_time';

                    $(slotContainer).empty();

                    $.ajax({
                        url: '{{ route('book.checkTime') }}',
                        type: 'GET',
                        data: {
                            date: selectedDate
                        },
                        success: function(response) {
                            if (response.closed) {
                                iziToast.info({
                                    title: 'Info',
                                    message: 'Booking untuk tanggal ini sedang ditutup.',
                                    position: 'topCenter',
                                });

                                $(slotContainer).html(
                                    '<div class="card bg-warning text-white p-3">Booking untuk tanggal ini sedang ditutup.</div>'
                                );
                            } else {
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

                                    if (isBooked || isCurrent) {
                                        $(slotContainer).append(`
                                        <button type="button" class="btn btn-outline-danger m-1 time-slot" disabled>
                                            ${timeString}
                                        </button>
                                    `);
                                    } else {
                                        $(slotContainer).append(`
                                        <button type="button" class="btn btn-outline-success m-1 time-slot" data-time="${timeString}">
                                            ${timeString}
                                        </button>
                                    `);
                                    }
                                }

                                // Event handler untuk memilih waktu
                                $(slotContainer).off('click', '.time-slot').on('click', '.time-slot',
                                    function() {
                                        $(inputField).val($(this).data('time'));
                                        $(slotContainer + ' .time-slot').removeClass('btn-success')
                                            .addClass('btn-outline-success');
                                        $(this).removeClass('btn-outline-success').addClass(
                                            'btn-success');
                                    }
                                );
                            }
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
