@extends('layouts.app', [
    'title' => 'Booking Preview ' . $users->name,
])

@section('konten')
    <div class="card p-4">
        <div class="row">
            <h2>
                Booking {{ request()->input('package') }} Self Photoshoot
            </h2>

            <div class="col-lg-8 col-sm-12">
                <div class="form-group mb-3">
                    <label for="booking_date">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}" class="form-control" autocomplete="off"
                        required readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="booking_date">Email</label>
                    <input type="text" name="email" value="{{ Auth::user()->email }}" class="form-control"
                        autocomplete="off" required readonly>
                </div>

                <div class="form-group mb-3">
                    <label for="booking_date">No Whatsapp</label>
                    <input class="form-control" type="text" id="no_tlp-{{ $users->id }}" name="no_tlp"
                        value="{{ $users->no_tlp }}"
                        oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                        placeholder="082244876123" utocomplete="off" required />
                </div>

                <div class="mb-1">{{ request()->input('package') }} Self Photoshoot</div>

                <ul>
                    <li class="mb-2">Unlimited Person</li>
                    <li class="mb-2">15 Minutes Photoshoot</li>
                    <li class="mb-2">10 Minutes Photo Selection</li>
                    <li class="mb-2">Free to choose all background colors</li>
                    <li class="mb-2">Free all props</li>
                </ul>

                <div class="mb-1">Additional Print</div>

                <ul>
                    <li class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>1 Printed Photo 4R : 10K</span>
                            <span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-minus" data-price="10"
                                    data-target="photo4r">-</button>
                                <span id="qty-photo4r" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="10"
                                    data-target="photo4r">+</button>
                            </span>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>2 Printed Strip : 10K</span>
                            <span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-minus" data-price="10"
                                    data-target="strip">-</button>
                                <span id="qty-strip" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="10"
                                    data-target="strip">+</button>
                            </span>
                        </div>
                    </li>
                    <li class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>1 Printed Holoflip 4R : 25K</span>
                            <span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-minus" data-price="25"
                                    data-target="holoflip">-</button>
                                <span id="qty-holoflip" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="25"
                                    data-target="holoflip">+</button>
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="mb-1">Digital Soft Copy</div>

                <ul>
                    <li class="mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>All Color : 25K</span>
                            <span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-minus" data-price="25"
                                    data-target="allcolor">-</button>
                                <span id="qty-allcolor" class="mx-2">0</span>
                                <button type="button" class="btn btn-sm btn-outline-secondary qty-plus" data-price="25"
                                    data-target="allcolor">+</button>
                            </span>
                        </div>
                    </li>
                </ul>

                <div class="mb-3">* All Color Free (Tag IGS @sweetmoriesstudio + Follow + Google Review) Jangan Tambah
                    Digital Soft Copy All Color</div>

                <h3>Total Price: <span id="total-price">47K</span></h3>
            </div>

            <div class="col-lg-4 col-sm-12">
                <div id="#booking-preview" class="row">
                    <div class="col-md-12">
                        <form action="{{ route('book.store') }}" method="POST">
                            @csrf
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

                            <!-- Hidden Inputs for Additional Prints and Digital Soft Copy -->
                            <input type="hidden" id="hidden-package" name="items[0][product_name]" value="">
                            <input type="hidden" id="hidden-package-qty" name="items[0][quantity]" value="1">

                            <input type="hidden" id="hidden-photo4r" name="items[1][product_name]"
                                value="1 Printed Photo 4R">
                            <input type="hidden" id="hidden-strip" name="items[2][product_name]"
                                value="2 Printed Strip">
                            <input type="hidden" id="hidden-holoflip" name="items[3][product_name]"
                                value="1 Printed Holoflip 4R">
                            <input type="hidden" id="hidden-allcolor" name="items[4][product_name]"
                                value="Digital Soft Copy">
                            <input type="hidden" id="hidden-photo4r-qty" name="items[1][quantity]" value="0">
                            <input type="hidden" id="hidden-strip-qty" name="items[2][quantity]" value="0">
                            <input type="hidden" id="hidden-holoflip-qty" name="items[3][quantity]" value="0">
                            <input type="hidden" id="hidden-allcolor-qty" name="items[4][quantity]" value="0">

                            <button type="submit" class="btn btn-primary mt-3">Book Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js-konten')
        <script>
            $(document).ready(function() {
                const package = "{{ request()->input('package') }}";

                // Set initial total price based on package
                let totalPrice = package === 'Projector' ? 70 : 47;
                $('#hidden-package').val(package === 'Projector' ? 'Projector Self Photoshoot' :
                    'Basic Self Photoshoot');
                $('#total-price').text(totalPrice + 'K');

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

                            for (let time = start; time < end; time += 20) {
                                const hours = String(Math.floor(time / 60)).padStart(2, '0');
                                const minutes = String(time % 60).padStart(2, '0');
                                const timeString = `${hours}:${minutes}`;

                                const timeCard = $('<div class="card m-1 p-2">').text(timeString).css(
                                    'cursor', 'pointer');

                                if (bookedTimes.includes(timeString)) {
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

                // Fungsi untuk memperbarui harga total
                function updateTotalPrice() {
                    $('#total-price').text(totalPrice + 'K');
                }

                // Event handler untuk tombol tambah
                $('.qty-plus').click(function() {
                    const target = $(this).data('target');
                    const price = parseInt($(this).data('price'));
                    let qty = parseInt($('#qty-' + target).text());

                    qty++;
                    $('#qty-' + target).text(qty);

                    // Update hidden input
                    $('#hidden-' + target + '-qty').val(qty);

                    totalPrice += price;
                    updateTotalPrice();
                });

                // Event handler untuk tombol kurang
                $('.qty-minus').click(function() {
                    const target = $(this).data('target');
                    const price = parseInt($(this).data('price'));
                    let qty = parseInt($('#qty-' + target).text());

                    if (qty > 0) {
                        qty--;
                        $('#qty-' + target).text(qty);

                        // Update hidden input
                        $('#hidden-' + target + '-qty').val(qty);

                        totalPrice -= price;
                        updateTotalPrice();
                    }
                });
            });
        </script>
    @endpush
@endsection
