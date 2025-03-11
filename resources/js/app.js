import './bootstrap';

// Mobile menu toggle
document.addEventListener('DOMContentLoaded', () => {
    const mobileMenuButton = document.querySelector('[data-mobile-menu-button]');
    const mobileMenu = document.querySelector('[data-mobile-menu]');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    }
});

// Flash message auto-hide
document.addEventListener('DOMContentLoaded', () => {
    const flashMessages = document.querySelectorAll('[data-flash-message]');

    flashMessages.forEach(message => {
        setTimeout(() => {
            message.classList.add('opacity-0');
            setTimeout(() => {
                message.remove();
            }, 300);
        }, 3000);
    });
});

// Form validation
document.addEventListener('DOMContentLoaded', () => {
    const forms = document.querySelectorAll('form[data-validate]');

    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;

            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');

                    const errorMessage = field.dataset.errorMessage || 'This field is required';
                    const errorElement = document.createElement('p');
                    errorElement.classList.add('text-red-500', 'text-sm', 'mt-1');
                    errorElement.textContent = errorMessage;

                    field.parentNode.appendChild(errorElement);
                }
            });

            if (!isValid) {
                e.preventDefault();
            }
        });
    });
});
