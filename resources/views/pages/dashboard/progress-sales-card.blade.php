
{{-- Today Sales --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Today Target Sales</h5>
        <div class="card-subtitle text-muted mb-3">Target Sales Anda Hari Ini Sebesar {{ $targetSalesToday }}</div>
        <div class="demo-vertical-spacing demo-only-element mb-3">
            @if ($progressSalesTodayPercent == 0)
                <div class="progress text-dark" style="height: 20px">
                    <div class="p-1 text-dark">
                        Belum Ada Progress
                    </div>
                </div>
            @elseif ($progressSalesTodayPercent <= 25)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @elseif ($progressSalesTodayPercent <= 50)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @elseif ($progressSalesTodayPercent <= 75)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @elseif ($progressSalesTodayPercent <= 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @elseif ($progressSalesTodayPercent > 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0"
                        aria-valuemax="{{ $progressSalesTodayPercent }}">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @else
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar"
                        style="width: {{ $progressSalesTodayPercent }}%"
                        aria-valuenow="{{ $progressSalesTodayPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesTodayPercent }} %</div>
                </div>
            @endif

        </div>
        @if ($progressSalesTodayPercent == 0)
            <p class="card-text">
                Anda belum berprogress segera mulai progress dengan semangat baru, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent <= 25)
            <p class="card-text">
                Anda masih jauh dari target semoga target anda hari ini tercapai, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent <= 50)
            <p class="card-text">
                Progress anda meningkat namun masih jauh dari target jangan patah semangat, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent <= 75)
            <p class="card-text">
                Ayo terus berusaha mencapai target, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent < 100)
            <p class="card-text">
                Sedikit lagi anda mencapai target tetap semangat, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent == 100)
            <p class="card-text">
                Selamat anda telah mencapai target terima kasih sudah berdedikasi untuk perusahaan semoga sehat selalu, Total sales anda hari ini sebesar
                {{ $progresSalesTodayValue }}
            </p>
        @elseif ($progressSalesTodayPercent > 100)
            <p class="card-text">
                Wow keren anda melebihi target sales hari ini terima kasih sudah berdedikasi lebih untuk perusahaan
                semoga sehat dan sukses selalu, Total sales anda hari ini sebesar {{ $progresSalesTodayValue }}
            </p>
        @else
        @endif
    </div>
</div>
{{-- / Today Sales --}}

{{-- Monthly Sales --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Monthly Target Sales</h5>
        <div class="card-subtitle text-muted mb-3">Target Sales Anda bulan ini Sebesar {{ $targetSalesMonthly }}</div>
        <div class="demo-vertical-spacing demo-only-element mb-3">
            @if ($progressSalesMonthlyPercent == 0)
                <div class="progress text-dark" style="height: 20px">
                    <div class="p-1 text-dark">
                        Belum Ada Progress
                    </div>
                </div>
            @elseif ($progressSalesMonthlyPercent <= 25)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @elseif ($progressSalesMonthlyPercent <= 50)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @elseif ($progressSalesMonthlyPercent <= 75)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @elseif ($progressSalesMonthlyPercent <= 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @elseif ($progressSalesMonthlyPercent > 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0"
                        aria-valuemax="{{ $progressSalesMonthlyPercent }}">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @else
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar"
                        style="width: {{ $progressSalesMonthlyPercent }}%"
                        aria-valuenow="{{ $progressSalesMonthlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesMonthlyPercent }} %</div>
                </div>
            @endif

        </div>
        @if ($progressSalesMonthlyPercent == 0)
            <p class="card-text">
                Anda belum berprogress segera mulai progress dengan semangat baru, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent <= 25)
            <p class="card-text">
                Anda masih jauh dari target semoga target anda bulan ini tercapai, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent <= 50)
            <p class="card-text">
                Progress anda meningkat namun masih jauh dari target jangan patah semangat, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent <= 75)
            <p class="card-text">
                Ayo terus berusaha mencapai target, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent < 100)
            <p class="card-text">
                Sedikit lagi anda mencapai target tetap semangat, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent == 100)
            <p class="card-text">
                Selamat anda telah mencapai target terima kasih sudah berdedikasi untuk perusahaan semoga sehat selalu, Total sales anda bulan ini sebesar
                {{ $progresSalesMonthlyValue }}
            </p>
        @elseif ($progressSalesMonthlyPercent > 100)
            <p class="card-text">
                Wow keren anda melebihi target sales bulan ini terima kasih sudah berdedikasi lebih untuk perusahaan
                semoga sehat dan sukses selalu, Total sales anda bulan ini sebesar {{ $progresSalesMonthlyValue }}
            </p>
        @else
        @endif
    </div>
</div>
{{-- / Monthly Sales --}}

{{-- Yearly Sales --}}
<div class="card mb-4">
    <div class="card-body">
        <h5 class="card-title">Yearly Target Sales</h5>
        <div class="card-subtitle text-muted mb-3">Target Sales Anda tahun ini Sebesar {{ $targetSalesYearly }}</div>
        <div class="demo-vertical-spacing demo-only-element mb-3">
            @if ($progressSalesYearlyPercent == 0)
                <div class="progress text-dark" style="height: 20px">
                    <div class="p-1 text-dark">
                        Belum Ada Progress
                    </div>
                </div>
            @elseif ($progressSalesYearlyPercent <= 25)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @elseif ($progressSalesYearlyPercent <= 50)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @elseif ($progressSalesYearlyPercent <= 75)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @elseif ($progressSalesYearlyPercent <= 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @elseif ($progressSalesYearlyPercent > 100)
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0"
                        aria-valuemax="{{ $progressSalesYearlyPercent }}">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @else
                <div class="progress" style="height: 20px">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-dark" role="progressbar"
                        style="width: {{ $progressSalesYearlyPercent }}%"
                        aria-valuenow="{{ $progressSalesYearlyPercent }}" aria-valuemin="0" aria-valuemax="100">
                        {{ $progressSalesYearlyPercent }} %</div>
                </div>
            @endif

        </div>
        @if ($progressSalesYearlyPercent == 0)
            <p class="card-text">
                Anda belum berprogress segera mulai progress dengan semangat baru, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent <= 25)
            <p class="card-text">
                Anda masih jauh dari target semoga target anda tahun ini tercapai, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent <= 50)
            <p class="card-text">
                Progress anda meningkat namun masih jauh dari target jangan patah semangat, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent <= 75)
            <p class="card-text">
                Ayo terus berusaha mencapai target, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent < 100)
            <p class="card-text">
                Sedikit lagi anda mencapai target tetap semangat, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent == 100)
            <p class="card-text">
                Selamat anda telah mencapai target terima kasih sudah berdedikasi untuk perusahaan semoga sehat selalu, Total sales anda tahun ini sebesar
                {{ $progresSalesYearlyValue }}
            </p>
        @elseif ($progressSalesYearlyPercent > 100)
            <p class="card-text">
                Wow keren anda melebihi target sales tahun ini terima kasih sudah berdedikasi lebih untuk perusahaan
                semoga sehat dan sukses selalu, Total sales anda tahun ini sebesar {{ $progresSalesYearlyValue }}
            </p>
        @else
        @endif
    </div>
</div>
{{-- / Yearly Sales --}}
