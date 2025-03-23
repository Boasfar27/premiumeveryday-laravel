@extends('pages.mobile.layouts.app')

@section('title', $existingReview ? 'Edit Ulasan' : 'Tulis Ulasan')

@section('styles')
    <style>
        .star-rating {
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: center;
            direction: ltr;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            cursor: pointer;
            width: 42px;
            height: 42px;
            padding: 4px;
            margin: 0;
            transition: all 0.2s ease-in-out;
        }

        .star-rating svg {
            width: 100%;
            height: 100%;
            transition: all 0.2s ease;
        }

        .star-rating input:checked~label svg path {
            fill: #FBBF24;
            stroke: #F59E0B;
            stroke-width: 1;
        }

        .star-rating label:hover~label svg path,
        .star-rating label:hover svg path {
            fill: #FCD34D;
            stroke: #F59E0B;
            stroke-width: 1;
            filter: drop-shadow(0 0 2px rgba(245, 158, 11, 0.5));
        }

        .star-rating label:hover {
            transform: scale(1.2);
        }

        .rating-value {
            font-weight: bold;
            margin-left: 12px;
            font-size: 1.1rem;
            color: #F59E0B;
        }

        .rating-container {
            background-color: #F9FAFB;
            border-radius: 8px;
            padding: 12px;
        }
    </style>
@endsection

@section('content')
    <div class="bg-white min-h-screen">
        <!-- Header -->
        <div class="relative bg-white shadow">
            <div class="flex items-center h-16 px-4">
                <a href="{{ route('user.payments.detail', $order) }}" class="mr-4">
                    <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                </a>
                <h1 class="text-xl font-bold text-gray-900">{{ $existingReview ? 'Edit Ulasan' : 'Tulis Ulasan' }}</h1>
            </div>
        </div>

        <div class="px-4 py-6">
            <!-- Produk yang dibeli -->
            <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                <h2 class="text-sm font-medium text-gray-700 mb-3">Produk yang Anda Beli</h2>
                <div class="space-y-4">
                    @foreach ($order->items as $item)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                @if ($item->orderable && method_exists($item->orderable, 'getFirstMediaUrl') && $item->orderable->getFirstMediaUrl())
                                    <img class="h-14 w-14 object-cover rounded-md"
                                        src="{{ $item->orderable->getFirstMediaUrl() }}" alt="{{ $item->orderable->name }}">
                                @else
                                    <div class="h-14 w-14 rounded-md bg-gray-200 flex items-center justify-center">
                                        <svg class="h-7 w-7 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $item->orderable->name }}</h3>
                                <p class="text-xs text-gray-500">
                                    {{ $item->subscription_type ?? 'Standard' }}
                                    @if ($item->duration)
                                        ({{ $item->duration }} bulan)
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Form -->
            <form
                action="{{ $existingReview ? route('user.payments.review.update', ['order' => $order->id, 'review' => $existingReview->id]) : route('user.payments.review.store', $order) }}"
                method="POST">
                @csrf
                @if ($existingReview)
                    @method('PUT')
                @endif

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Rating Produk</label>
                    <div class="rating-container">
                        <div class="flex items-center justify-center">
                            <div class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" id="rating-{{ $i }}" name="rating"
                                        value="{{ $i }}"
                                        {{ old('rating', $existingReview->rating ?? 5) == $i ? 'checked' : '' }}>
                                    <label for="rating-{{ $i }}" title="{{ $i }} bintang">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                            class="{{ $i <= old('rating', $existingReview->rating ?? 5) ? 'text-yellow-400' : 'text-gray-300' }}">
                                            <path d="M12 2l2.4 7.4h7.6l-6 4.6 2.3 7-6.3-4.6-6.3 4.6 2.3-7-6-4.6h7.6z"
                                                fill="currentColor" stroke="currentColor" stroke-width="0.5" />
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            <span class="rating-value"
                                id="rating-display">{{ old('rating', $existingReview->rating ?? 5) }} / 5</span>
                        </div>
                    </div>
                    @error('rating')
                        <span class="block text-center text-red-600 text-sm mt-1">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Content -->
                <div class="mb-6">
                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">Komentar Anda</label>
                    <textarea id="content" name="content" rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary focus:ring-primary"
                        placeholder="Bagikan pengalaman Anda dengan produk ini...">{{ old('content', $existingReview->content ?? '') }}</textarea>
                    <p class="text-sm text-gray-500 mt-2">Minimal 10 karakter</p>
                    @error('content')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="flex justify-end space-x-3 mt-8">
                    <a href="{{ route('user.payments.detail', $order) }}"
                        class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                        Batal
                    </a>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-pink-600 hover:bg-pink-700">
                        {{ $existingReview ? 'Perbarui Ulasan' : 'Kirim Ulasan' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const starLabels = document.querySelectorAll('.star-rating label');
                const ratingInputs = document.querySelectorAll('.star-rating input');
                const ratingDisplay = document.getElementById('rating-display');

                // Update display initially
                updateRatingDisplay();

                // Add event listeners to update the display when rating changes
                ratingInputs.forEach(input => {
                    input.addEventListener('change', updateRatingDisplay);
                });

                function updateRatingDisplay() {
                    const selectedRating = document.querySelector('.star-rating input:checked').value;
                    ratingDisplay.textContent = selectedRating + ' / 5';
                }

                starLabels.forEach(label => {
                    label.addEventListener('mouseenter', function() {
                        const value = parseInt(this.getAttribute('for').split('-')[1]);

                        // Update all stars based on hovered value
                        starLabels.forEach(l => {
                            const starValue = parseInt(l.getAttribute('for').split('-')[1]);
                            const svg = l.querySelector('svg');

                            if (starValue <= value) {
                                svg.classList.add('text-yellow-400');
                                svg.classList.remove('text-gray-300');
                            } else {
                                svg.classList.remove('text-yellow-400');
                                svg.classList.add('text-gray-300');
                            }
                        });
                    });
                });

                const starRating = document.querySelector('.star-rating');
                starRating.addEventListener('mouseleave', function() {
                    const checkedValue = parseInt(document.querySelector('.star-rating input:checked').value);

                    // Reset to checked state
                    starLabels.forEach(label => {
                        const starValue = parseInt(label.getAttribute('for').split('-')[1]);
                        const svg = label.querySelector('svg');

                        if (starValue <= checkedValue) {
                            svg.classList.add('text-yellow-400');
                            svg.classList.remove('text-gray-300');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
