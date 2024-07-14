@php
    use App\Http\Controllers\InspiringController;
@endphp
<div class="card">
    <div class="d-flex align-items-end row">
        <div class="col-sm-7">
            <div class="card-body">
                <h5 class="card-title text-primary">Hello {{Auth::user()->name}}</h5>
                <p class="mb-4">
                    Enjoy your work and have a nice day ✨
                    <br> ---
                    <br>
                    {!!InspiringController::quote()!!}
                </p>
                <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
            </div>
        </div>
        <div class="col-sm-5 text-center text-sm-left">
            <div class="card-body pb-0 px-0 px-md-4">
                <img src="{{ asset('template') }}/assets/img/illustrations/man-with-laptop-light.png" height="140"
                    alt="User">
            </div>
        </div>
    </div>
</div>
