import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        margin: String // Margin value used for IntersectionObserver
    }

    connect() {
        const ROOT_MARGIN = this.marginValue || '0px 0px -20px 0px'; // Default margin if not provided

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
        this.observer.disconnect();
    }

    animateElement(entries) {
        entries.forEach(entry => {
            // Check if the element is intersecting (visible in viewport)
            if (entry.isIntersecting) {
                const animationClass = this.element.dataset.animation || 'fade-in-up-effects'; // Default animation class

                // Add the animation class to the target element
                entry.target.classList.add(animationClass);

                // Remove the animation class and reset styles after animation ends
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
