@extends('layouts.app', [
    'title' => 'Book Reschedule',
])

@section('konten')
    @php
        $now = \Carbon\Carbon::now(); // Get the current time using Carbon
        $currentTime = $now->hour * 60 + $now->minute; // Calculate current time in minutes
    @endphp

    <h2 class="text-center mt-2">
        Update Jadwal Tutup {{ $datas->name }}
    </h2>

    <form action="{{ route('update-setting-outlet', $datas->id) }}" method="POST">
        @csrf
        <div class="card p-4 mt-3">
            <h3>
                Sebelum
            </h3>
            <div class="row">
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
            </div>
        </div>


        <div class="card p-4 mt-3">
            <div class="row">
                <h3>
                    Akan Di Update
                </h3>
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
                    generateTimeSlots(e.format(), type);
                });

                function generateTimeSlots(selectedDate, type) {
                    let slotContainer = type === 'start' ? '#start-time-slots' : '#end-time-slots';
                    let inputField = type === 'start' ? '#start_time' : '#end_time';

                    $(slotContainer).empty();

                    // Definisi jam kerja (09:00 - 21:00) dengan interval 20 menit
                    const start = 9 * 60; // 09:00 dalam menit
                    const end = 21 * 60; // 21:00 dalam menit
                    const currentDateTime = new Date();
                    const selectedDateTime = new Date(selectedDate);

                    for (let time = start; time <= end; time += 20) {
                        const hour = Math.floor(time / 60);
                        const minute = time % 60;
                        const timeString = hour.toString().padStart(2, '0') + ':' + minute.toString().padStart(2, '0');

                        const isPast = selectedDateTime.setHours(hour, minute, 0, 0) <= currentDateTime;

                        let buttonClass = isPast ? 'btn-outline-danger' : 'btn-outline-success';
                        let disabledAttr = isPast ? 'disabled' : '';

                        $(slotContainer).append(`
                <button type="button" class="btn ${buttonClass} m-1 time-slot" data-time="${timeString}" ${disabledAttr}>
                    ${timeString}
                </button>
            `);
                    }

                    // Event handler untuk memilih waktu
                    $(slotContainer).off('click', '.time-slot').on('click', '.time-slot', function() {
                        if (!$(this).is(':disabled')) {
                            $(inputField).val($(this).data('time'));
                            $(slotContainer + ' .time-slot').removeClass('btn-success').addClass(
                                'btn-outline-success');
                            $(this).removeClass('btn-outline-success').addClass('btn-success');
                        }
                    });
                }
            });
        </script>
    @endpush
@endsection
