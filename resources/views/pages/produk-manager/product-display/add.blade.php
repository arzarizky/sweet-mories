@extends('layouts.app', [
    'title' => 'Product Display Add',
])

@section('konten')
    <form action="{{ route('product-manager-product-display-add-store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card p-3">

            <div class="mb-3">
                <label for="name" class="form-label">Name Product Display</label>
                <input class="form-control" type="text" id="name" name="name" placeholder="Basic Self Photoshoot Promo"
                    required />
            </div>

            <!-- Existing Product Selection -->
            <div class="mb-3">
                <label for="product" class="form-label">Pilih Product</label>
                <select class="form-select" id="product" name="product_id" aria-label="select product" required>
                    <option selected="" value="">Pilih Product</option>
                    @forelse ($products as $product)
                        @if ($product->promo == 'true')
                            <option class="text-warning" value="{{ $product->id }}">
                                {{ $product->name }} {{ $product->type }}
                            </option>
                        @else
                            <option value="{{ $product->id }}">
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
                <select class="form-select" id="product_background" name="product_background" aria-label="select product"
                    required>
                    <option selected="" value="">Pilih Product</option>
                    @if ($ProductBackgrounds->count() === 0)
                        <option value="">Tidak Ada Product Background Yang Enable</option>
                    @else
                        <option value="Color">Color</option>
                        <option value="Projector">Projector</option>
                    @endif
                </select>
            </div>

            <!-- Dynamic Product Additional Selection -->
            <div class="mb-3">
                <label for="product_additional" class="form-label">Pilih Product Additional</label>
                <div id="additional-product-wrapper">
                    <div class="input-group mb-2">
                        <select class="form-select" name="product_additional_id[]" aria-label="select product">
                            <option value="">Pilih Product</option>
                            @forelse ($ProductAdditionals as $ProductAdditional)
                                <option value="{{ $ProductAdditional->id }}">{{ $ProductAdditional->name }}</option>
                            @empty
                                <option value="">Tidak Ada Product Additional Yang Enable</option>
                            @endforelse
                        </select>
                        <!-- Remove button (hidden for the first item) -->
                        <button type="button" class="btn btn-danger remove-additional-product" style="display:none;">
                            Remove
                        </button>
                    </div>
                </div>

                <!-- Add More Button -->
                <button type="button" id="add-more-additional" class="btn btn-success">Add More Product Additional</button>
            </div>

        </div>

        <div class="d-flex justify-content-between align-items-center mt-3">
            <a href="{{ route('product-manager-product-display') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Submit</button>
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
                // Create new input group with select dropdown
                let newInputGroup = document.createElement('div');
                newInputGroup.classList.add('input-group', 'mb-2');

                // Create new select dropdown
                let newSelect = document.createElement('select');
                newSelect.classList.add('form-select');
                newSelect.name = 'product_additional_id[]';
                newSelect.innerHTML = `
                <option value="">Pilih Product</option>
                @foreach ($ProductAdditionals as $ProductAdditional)
                    <option value="{{ $ProductAdditional->id }}">{{ $ProductAdditional->name }}</option>
                @endforeach
            `;

                // Create remove button
                let removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.classList.add('btn', 'btn-danger', 'remove-additional-product');
                removeButton.textContent = 'Remove';

                // Append select and remove button to input group
                newInputGroup.appendChild(newSelect);
                newInputGroup.appendChild(removeButton);

                // Append input group to wrapper
                additionalProductWrapper.appendChild(newInputGroup);

                // Show the remove button for additional rows
                document.querySelectorAll('.remove-additional-product').forEach(button => {
                    button.style.display = 'inline-block';
                });
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
