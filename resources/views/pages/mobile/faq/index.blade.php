@extends('pages.mobile.layouts.app')

@section('styles')
    <style>
        .faq-content ul,
        .faq-content ol {
            margin-left: 1.25rem;
            margin-bottom: 0.75rem;
        }

        .faq-content ul {
            list-style-type: disc;
        }

        .faq-content ol {
            list-style-type: decimal;
        }

        .faq-content p {
            margin-bottom: 0.5rem;
        }

        .faq-content h3 {
            font-weight: 600;
            margin-top: 0.75rem;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .faq-card {
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .faq-card:hover {
            border-left: 3px solid #EC4899;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .category-tab {
            transition: all 0.2s ease;
            flex: 1 0 auto;
            min-width: 80px;
            text-align: center;
        }

        .category-tab.active {
            background-color: #EC4899;
            color: white;
        }

        .search-highlight {
            background-color: rgba(236, 72, 153, 0.2);
            padding: 0 2px;
            border-radius: 2px;
        }

        .breadcrumb {
            display: flex;
            align-items: center;
            font-size: 0.75rem;
            color: #6B7280;
            margin-bottom: 1rem;
        }

        .breadcrumb-separator {
            margin: 0 0.25rem;
        }

        .popular-question {
            border-left: 3px solid #EC4899;
            background-color: #F9FAFB;
        }

        .help-card {
            transition: all 0.3s ease;
        }
    </style>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-6">
        <!-- Breadcrumb -->
        <div class="breadcrumb">
            <a href="{{ route('home') }}" class="hover:text-primary">Home</a>
            <span class="breadcrumb-separator">•</span>
            <span class="text-gray-500">Help Center</span>
        </div>

        <!-- Header -->
        <div class="bg-gradient-to-r from-pink-600 to-pink-500 rounded-lg p-4 mb-5">
            <h1 class="text-xl font-bold text-white mb-2 text-center">How can we help you?</h1>
            <p class="text-pink-100 mb-3 text-sm text-center">Find answers to frequently asked questions</p>

            <!-- Search Bar -->
            <div class="relative">
                <input type="text" id="faq-search" placeholder="Search for answers..."
                    class="w-full px-4 py-2 rounded-full border-0 focus:ring-2 focus:ring-pink-300 text-gray-900 text-sm shadow-md"
                    autocomplete="off">
                <div class="absolute inset-y-0 right-0 flex items-center pr-3">
                    <button class="text-pink-600 focus:outline-none">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Help Categories -->
        <div class="grid grid-cols-3 gap-2 mb-6">
            <a href="#product-faqs" class="help-card bg-white p-3 rounded-lg shadow-sm border border-gray-100 text-center">
                <div class="text-pink-600 bg-pink-50 w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-xs mb-1">Products</h3>
            </a>

            <a href="#payment-faqs" class="help-card bg-white p-3 rounded-lg shadow-sm border border-gray-100 text-center">
                <div class="text-pink-600 bg-pink-50 w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-xs mb-1">Payments</h3>
            </a>

            <a href="#account-faqs" class="help-card bg-white p-3 rounded-lg shadow-sm border border-gray-100 text-center">
                <div class="text-pink-600 bg-pink-50 w-8 h-8 mx-auto rounded-full flex items-center justify-center mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h3 class="font-medium text-gray-900 text-xs mb-1">Account</h3>
            </a>
        </div>

        <!-- Popular Questions -->
        <div class="mb-6">
            <h2 class="text-lg font-bold text-gray-900 mb-3">Popular Questions</h2>
            <div class="space-y-2">
                @foreach ($faqs->where('is_active', true)->take(3) as $popularFaq)
                    <div class="popular-question p-3 rounded-lg">
                        <h3 class="font-medium text-gray-900 text-sm mb-1">{{ $popularFaq->question }}</h3>
                        <p class="text-gray-500 text-xs line-clamp-1">{{ strip_tags($popularFaq->answer) }}</p>
                        <a href="#faq-{{ $popularFaq->id }}"
                            class="text-pink-600 text-xs font-medium mt-1 inline-block">Read
                            more</a>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Category Tabs -->
        <div class="overflow-x-auto -mx-4 px-4 mb-4">
            <div class="flex space-x-2 pb-2 border-b border-gray-200" id="category-tabs">
                <button class="category-tab active px-3 py-1.5 rounded-t-md text-xs font-medium" data-category="all">
                    All FAQs
                </button>
                @foreach (App\Models\Faq::categories() as $categoryKey => $categoryName)
                    @if (in_array($categoryKey, $categories))
                        <button class="category-tab px-3 py-1.5 rounded-t-md text-xs font-medium bg-gray-100 text-gray-700"
                            data-category="{{ $categoryKey }}" id="{{ $categoryKey }}-faqs">
                            {{ $categoryName }}
                        </button>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="space-y-3" id="faq-container">
            @foreach ($faqs as $faq)
                <div x-data="{ open: false }" class="bg-white rounded-lg faq-card" data-category="{{ $faq->category }}"
                    id="faq-{{ $faq->id }}">
                    <button @click="open = !open" class="w-full flex justify-between items-center p-4 focus:outline-none">
                        <span class="text-sm font-medium text-gray-900 text-left">{{ $faq->question }}</span>
                        <svg class="w-4 h-4 text-pink-600 flex-shrink-0 ml-2" :class="{ 'transform rotate-180': open }"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div x-show="open" class="px-4 pb-4" x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-4"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-start="opacity-100 transform translate-y-0"
                        x-transition:leave-end="opacity-0 transform -translate-y-4">
                        <div class="text-xs text-gray-600 faq-content">{!! $faq->answer !!}</div>

                        <!-- Helpfulness rating -->
                        <div class="mt-3 pt-3 border-t border-gray-100 flex items-center justify-between">
                            <div class="text-xs text-gray-500">Was this helpful?</div>
                            <div class="flex space-x-2">
                                <button
                                    class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs hover:bg-gray-200 transition-colors">
                                    Yes
                                </button>
                                <button
                                    class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs hover:bg-gray-200 transition-colors">
                                    No
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="no-results" class="hidden mt-6 p-4 text-center bg-gray-50 rounded-lg">
            <svg class="w-8 h-8 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="mt-2 text-gray-900 font-medium text-sm">No matching questions found</h3>
            <p class="mt-1 text-gray-500 text-xs">Try adjusting your search terms</p>
        </div>

        <!-- Contact Support -->
        <div class="mt-8 bg-gray-50 rounded-lg p-4 border border-gray-200">
            <h3 class="text-base font-bold text-gray-900 mb-2">Still have questions?</h3>
            <p class="text-gray-600 text-xs mb-3">Can't find the answer you're looking for? Our customer support team is
                ready to help.</p>
            <a href="{{ route('contact') }}"
                class="inline-flex items-center px-3 py-1.5 bg-primary text-white text-xs rounded hover:bg-primary-dark transition-colors">
                Contact our support team
                <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                </svg>
            </a>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Category filtering
            const categoryTabs = document.querySelectorAll('.category-tab');
            const faqItems = document.querySelectorAll('#faq-container > div');

            // Check for hash in URL to auto-select category
            const hash = window.location.hash;
            if (hash) {
                const categoryId = hash.replace('#', '').replace('-faqs', '');
                const tabToActivate = document.querySelector(`[data-category="${categoryId}"]`);
                if (tabToActivate) {
                    categoryTabs.forEach(t => t.classList.remove('active'));
                    categoryTabs.forEach(t => t.classList.add('bg-gray-100', 'text-gray-700'));
                    tabToActivate.classList.add('active');
                    tabToActivate.classList.remove('bg-gray-100', 'text-gray-700');

                    faqItems.forEach(item => {
                        if (categoryId === 'all' || item.dataset.category === categoryId) {
                            item.classList.remove('hidden');
                        } else {
                            item.classList.add('hidden');
                        }
                    });
                }
            }

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

                // Process text nodes for complex HTML content
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

            // Handle clicking on popular question links
            document.querySelectorAll('.popular-question a').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href');
                    const targetFaq = document.querySelector(targetId);

                    if (targetFaq) {
                        // Make category visible
                        const category = targetFaq.dataset.category;
                        const categoryTab = document.querySelector(`[data-category="${category}"]`);

                        if (categoryTab) {
                            categoryTab.click();
                        }

                        // Open the FAQ
                        const faqButton = targetFaq.querySelector('button');
                        const faqOpen = targetFaq.__x.$data.open;

                        if (!faqOpen) {
                            faqButton.click();
                        }

                        // Scroll to the FAQ
                        targetFaq.scrollIntoView({
                            behavior: 'smooth',
                            block: 'center'
                        });

                        // Highlight the FAQ
                        targetFaq.classList.add('ring-2', 'ring-primary', 'ring-opacity-50');
                        setTimeout(() => {
                            targetFaq.classList.remove('ring-2', 'ring-primary',
                                'ring-opacity-50');
                        }, 2000);
                    }
                });
            });
        });
    </script>
@endsection
