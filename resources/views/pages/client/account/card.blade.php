<form method="POST" action="{{ route('account-client-update', ['email' => $users->email, 'id' => $users->id]) }}"
    enctype="multipart/form-data">
    @csrf
    <h5 class="card-header">Profile Details</h5>

    <div class="card-body">
        <div class="d-flex align-items-start align-items-sm-center gap-4 ">
            @if ($users->avatar === null)
                <img src="{{ asset('template') }}/assets/img/avatars/avatar-1.png" alt="user-avatar"
                    class="d-block rounded" height="100" width="100" id="uploadedAvatar" />
            @else
                <img src="{{ $users->getPicAvatarAdmin() }}" alt="user-avatar" class="d-block rounded" height="100"
                    width="100" id="uploadedAvatar" />
            @endif
            <div class="button-wrapper">
                <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                    <span class="d-none d-sm-block">Upload new photo</span>
                    <i class="bx bx-upload d-block d-sm-none"></i>
                    <input type="file" id="upload" class="account-file-input" hidden
                        accept="image/png, image/jpeg" name="avatar" />
                </label>
                <button type="button" class="btn btn-outline-secondary account-image-reset mb-4">
                    <i class="bx bx-reset d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Reset</span>
                </button>

                <p class="text-muted mb-0">Allowed JPG or PNG</p>
            </div>
        </div>
    </div>
    <hr class="my-0" />
    <div class="card-body">


        <div class="mt-3 mb-3">
            <label for="name-{{ $users->id }}" class="form-label">Nama Lengkap</label>
            <input class="form-control" type="text" id="name-{{ $users->id }}" name="name"
                placeholder="John Doe" value="{{ $users->name }}" required />
        </div>


        <div class="row">
            <div class="mb-3 col-md-6">
                <label for="no_tlp-{{ $users->id }}" class="form-label">No Whatsapp</label>
                <input class="form-control" type="text" id="no_tlp-{{ $users->id }}" name="no_tlp"
                    value="{{ $users->no_tlp }}"
                    oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"
                    placeholder="082244876123" required />
            </div>

            <div class="mb-3 col-md-6">
                <label for="email-{{ $users->id }}" class="form-label">E-mail</label>
                <input class="form-control" type="text" id="email-{{ $users->id }}" name="email"
                    value="{{ $users->email }}" placeholder="john.doe@example.com" required />
            </div>
        </div>

        <div class="mt-2">
            <button type="submit" class="btn btn-primary me-2">Save changes</button>
            <button type="reset" class="btn btn-outline-secondary">Cancel</button>
        </div>
    </div>

</form>


@push('css-konten')
    <link rel="stylesheet" href="{{ asset('template') }}/assets/vendor/css/pages/page-auth.css" />
@endpush

@push('js-konten')
    <script src="{{ asset('template') }}/assets/js/pages-account-settings-account.js"></script>
@endpush
