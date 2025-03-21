@extends('pages.desktop.layouts.app')

@section('styles')
    <style>
        .faq-content ul,
        .faq-content ol {
            margin-left: 1.5rem;
            margin-bottom: 1rem;
        }

        .faq-content ul {
            list-style-type: disc;
        }

        .faq-content ol {
            list-style-type: decimal;
        }

        .faq-content p {
            margin-bottom: 0.75rem;
        }

        .faq-content h3 {
            font-weight: 600;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .faq-card {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .faq-card:hover {
            border-left: 3px solid #4F46E5;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category-tab {
            transition: all 0.2s ease;
        }

        .category-tab.active {
            background-color: #4F46E5;
            color: white;
        }

        .search-highlight {
            background-color: rgba(79, 70, 229, 0.2);
            padding: 0 2px;
            border-radius: 2px;
        }
    </style>
@endsection

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 pt-24">
        <div class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl p-8 mb-10">
            <div class="max-w-3xl mx-auto text-center">
                <h1 class="text-3xl font-bold text-white mb-4">Frequently Asked Questions</h1>
                <p class="text-indigo-100 mb-6">Temukan jawaban untuk pertanyaan umum tentang layanan dan produk digital
                    kami.</p>

                <!-- Search Bar -->
                <div class="relative max-w-xl mx-auto">
                    <input type="text" id="faq-search" placeholder="Search for answers..."
                        class="w-full px-4 py-3 rounded-full border-0 focus:ring-2 focus:ring-indigo-300 text-gray-900"
                        autocomplete="off">
                    <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-4xl mx-auto">
            <!-- Category Tabs -->
            <div class="flex flex-wrap justify-center mb-8 gap-2" id="category-tabs">
                <button class="category-tab active px-4 py-2 rounded-full text-sm font-medium" data-category="all">
                    All FAQs
                </button>
                @foreach (App\Models\Faq::categories() as $categoryKey => $categoryName)
                    @if (in_array($categoryKey, $categories))
                        <button class="category-tab px-4 py-2 rounded-full text-sm font-medium bg-gray-100 text-gray-700"
                            data-category="{{ $categoryKey }}">
                            {{ $categoryName }}
                        </button>
                    @endif
                @endforeach
            </div>

            <div class="space-y-6" id="faq-container">
                @foreach ($faqs as $faq)
                    <div x-data="{ open: false }" class="bg-white rounded-lg faq-card" data-category="{{ $faq->category }}">
                        <button @click="open = !open"
                            class="w-full flex justify-between items-center p-5 focus:outline-none">
                            <span class="text-lg font-medium text-gray-900 text-left">{{ $faq->question }}</span>
                            <svg class="w-5 h-5 text-primary flex-shrink-0 ml-2" :class="{ 'transform rotate-180': open }"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div x-show="open" class="px-5 pb-5" x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform -translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            x-transition:leave="transition ease-in duration-300"
                            x-transition:leave-start="opacity-100 transform translate-y-0"
                            x-transition:leave-end="opacity-0 transform -translate-y-4">
                            <div class="text-gray-600 faq-content">{!! $faq->answer !!}</div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div id="no-results" class="hidden mt-8 p-6 text-center bg-gray-50 rounded-lg">
                <svg class="w-12 h-12 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="mt-2 text-gray-900 font-medium">No matching questions found</h3>
                <p class="mt-1 text-gray-500">Try adjusting your search terms or browse all categories</p>
            </div>

            <div class="mt-12 text-center">
                <p class="text-gray-600">Still have questions?</p>
                <a href="{{ route('contact') }}"
                    class="inline-flex items-center mt-2 px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">
                    Contact our support team
                    <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8l4 4m0 0l-4 4m4-4H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category filtering
            const categoryTabs = document.querySelectorAll('.category-tab');
            const faqItems = document.querySelectorAll('#faq-container > div');

            categoryTabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Update active tab
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    categoryTabs.forEach(t => t.classList.add('bg-gray-100', 'text-gray-700'));
                    tab.classList.add('active');
                    tab.classList.remove('bg-gray-100', 'text-gray-700');

                    const category = tab.dataset.category;

                    // Show/hide FAQs based on category
                    faqItems.forEach(item => {
                        if (category === 'all' || item.dataset.category === category) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });

                    // Check if no results are shown
                    checkNoResults();
                });
            });

            // Search functionality
            const searchInput = document.getElementById('faq-search');
            const noResults = document.getElementById('no-results');

            searchInput.addEventListener('input', () => {
                const searchTerm = searchInput.value.toLowerCase().trim();

                faqItems.forEach(item => {
                    const question = item.querySelector('button span').textContent.toLowerCase();
                    const answer = item.querySelector('.faq-content').textContent.toLowerCase();

                    // Only search visible categories
                    if (!item.classList.contains('hidden') || document.querySelector(
                            '.category-tab.active').dataset.category === 'all') {
                        if (searchTerm === '' || question.includes(searchTerm) || answer.includes(
                                searchTerm)) {
                            item.classList.remove('hidden');

                            // Highlight search term
                            if (searchTerm !== '') {
                                highlightText(item, searchTerm);
                            } else {
                                // Remove highlights if search is cleared
                                removeHighlights(item);
                            }
                        } else {
                            item.classList.add('hidden');
                        }
                    }
                });

                // Check if no results are shown
                checkNoResults();
            });

            function highlightText(item, term) {
                removeHighlights(item);

                const questionEl = item.querySelector('button span');
                const answerEl = item.querySelector('.faq-content');

                questionEl.innerHTML = highlightMatch(questionEl.textContent, term);

                // Don't directly modify answer HTML as it might contain complex HTML
                // Just search for text nodes and highlight them
                const textNodes = getTextNodes(answerEl);
                textNodes.forEach(node => {
                    const parent = node.parentNode;
                    const text = node.nodeValue;

                    if (text.toLowerCase().includes(term)) {
                        const fragment = document.createDocumentFragment();
                        const highlightedHTML = highlightMatch(text, term);

                        const temp = document.createElement('div');
                        temp.innerHTML = highlightedHTML;

                        while (temp.firstChild) {
                            fragment.appendChild(temp.firstChild);
                        }

                        parent.replaceChild(fragment, node);
                    }
                });
            }

            function getTextNodes(node) {
                const textNodes = [];

                if (node.nodeType === 3) {
                    textNodes.push(node);
                } else {
                    const children = node.childNodes;
                    for (let i = 0; i < children.length; i++) {
                        textNodes.push(...getTextNodes(children[i]));
                    }
                }

                return textNodes;
            }

            function highlightMatch(text, term) {
                const regex = new RegExp(`(${term})`, 'gi');
                return text.replace(regex, '<span class="search-highlight">$1</span>');
            }

            function removeHighlights(item) {
                const highlights = item.querySelectorAll('.search-highlight');
                highlights.forEach(el => {
                    const parent = el.parentNode;
                    parent.replaceChild(document.createTextNode(el.textContent), el);
                    parent.normalize();
                });
            }

            function checkNoResults() {
                const visibleItems = Array.from(faqItems).filter(item => !item.classList.contains('hidden'));
                if (visibleItems.length === 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }
        });
    </script>
@endsection
