@foreach ($datas as $data)
    <div class="modal fade" id="viewPicture-{{ $data->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="d-flex justify-content-center">
                <img src="{{ $data->getPicProduct() }}" alt="Avatar" alt="user-avatar" class="d-block rounded"
                        style="width: 90%; height: auto;" />
            </div>
        </div>
    </div>
@endforeach
