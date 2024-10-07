@extends('layouts.app', [
    'title' => 'Product Display Edit',
])

@section('konten')
    <form action="{{ route('product-manager-product-display-edit-update', $data->id) }}" method="POST"
        enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="card p-3">

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Display</label>
                <input class="form-control" type="text" id="name" name="name" value="{{ $data->name }}"
                    required />
            </div>

            <!-- Existing Product Selection -->
            <div class="mb-3">
                <label for="product" class="form-label">Pilih Product</label>
                <select class="form-select" id="product" name="product_id" aria-label="select product" required>
                    <option value="">Pilih Product</option>
                    @forelse ($products as $product)
                        @if ($product->promo == 'true')
                            <option class="text-warning" value="{{ $product->id }}" {{ $data->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} {{ $product->type }}
                            </option>
                        @else
                            <option value="{{ $product->id }}" {{ $data->product_id == $product->id ? 'selected' : '' }}>
                                {{ $product->name }} {{ $product->type }}
                            </option>
                        @endif
                    @empty
                        <option value="">Tidak Ada Product Yang Enable</option>
                    @endforelse
                </select>
            </div>

            <!-- Existing Product Background Selection -->
            <div class="mb-3">
                <label for="product_background" class="form-label">Pilih Product Background</label>
                <select class="form-select" id="product_background" name="product_background" required>
                    <option value="">Pilih Product Background</option>
                    @if ($data->product_background == 'Color')
                        <option value="Color" selected>
                            Color
                        </option>
                        <option value="Projector">
                            Projector
                        </option>
                    @else
                        <option value="Color" selected>
                            Color
                        </option>
                        <option value="Projector" selected>
                            Projector
                        </option>
                    @endif
                </select>
            </div>

            <!-- Dynamic Product Additional Selection -->
            <div class="mb-3">
                <label for="product_additional" class="form-label">Pilih Product Additional</label>
                <div id="additional-product-wrapper">
                    @php
                        $data->product_additional_id = json_decode($data->product_additional_id, true);
                    @endphp
                    @if (!empty($data->product_additional_id) && is_array($data->product_additional_id))
                        @foreach ($data->product_additional_id as $additionalProductId)
                            <div class="input-group mb-2">
                                <select class="form-select" name="product_additional_id[]" aria-label="select product">
                                    <option value="">Pilih Product</option>
                                    @foreach ($ProductAdditionals as $ProductAdditional)
                                        <option value="{{ $ProductAdditional->id }}"
                                            {{ $additionalProductId == $ProductAdditional->id ? 'selected' : '' }}>
                                            {{ $ProductAdditional->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <!-- Remove button (displayed for additional items) -->
                                <button type="button" class="btn btn-danger remove-additional-product">
                                    Remove
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="text-muted">No additional products selected.</div>
                    @endif
                </div>

                <!-- Add More Button -->
                <button type="button" id="add-more-additional" class="btn btn-success">Add More Product Additional</button>
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('product-manager-product-display') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update</button>
        </div>
    </form>
@endsection

@push('js-konten')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let additionalProductWrapper = document.getElementById('additional-product-wrapper');
            let addMoreButton = document.getElementById('add-more-additional');

            // Handle adding new additional product dropdowns
            addMoreButton.addEventListener('click', function() {
                let newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');

                let newSelect = document.createElement('select');
                newSelect.classList.add('form-select');
                newSelect.name = 'product_additional_id[]';
                newSelect.innerHTML = `
                <option value="">Pilih Product</option>
                @foreach ($ProductAdditionals as $ProductAdditional)
                    <option value="{{ $ProductAdditional->id }}">{{ $ProductAdditional->name }}</option>
                @endforeach
                `;

                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'remove-additional-product');
                removeButton.textContent = 'Remove';

                newInputGroup.appendChild(newSelect);
                newInputGroup.appendChild(removeButton);
                additionalProductWrapper.appendChild(newInputGroup);
            });

            // Handle removing additional product dropdowns
            additionalProductWrapper.addEventListener('click', function(event) {
                if (event.target.classList.contains('remove-additional-product')) {
                    event.target.closest('.input-group').remove();
                }
            });
        });
    </script>
@endpush
