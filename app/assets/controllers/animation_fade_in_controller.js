import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        margin: String // Margin value used for IntersectionObserver
    }

    connect() {
        // Default margin if not provided
        const ROOT_MARGIN = this.marginValue || '0px 0px -20px 0px';

        // Initialize the IntersectionObserver with custom settings
        this.observer = new IntersectionObserver(this.animateElement.bind(this), {
            threshold: 0.1,
            rootMargin: ROOT_MARGIN
        });

        // Start observing the target element
        this.observer.observe(this.element);
    }

    disconnect() {
        // Disconnect the observer when the controller is disconnected
        if (this.observer) {
            this.observer.disconnect();
        }
    }

    animateElement(entries) {
        entries.forEach(entry => {
            // Check if the element is intersecting (visible in viewport)
            if (entry.isIntersecting) {
                // Default animation class if not specified in data attribute
                const animationClass = this.element.dataset.animation || 'fade-in-up-effects';

                // Add the animation class to the target element
                entry.target.classList.add(animationClass);

                // Event listener to clean up after animation ends
                entry.target.addEventListener('animationend', () => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translate(0)';
                    entry.target.style.animation = '';
                    entry.target.classList.remove(animationClass);
                }, { once: true });

                // Stop observing the element once the animation is triggered
                this.observer.unobserve(entry.target);
            }
        });
    }
}
