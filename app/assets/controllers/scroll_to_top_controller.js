import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['button'];

    connect() {
        // Bind the toggleButton method to the current instance
        this.toggleButton = this.toggleButton.bind(this);

        // Add scroll event listener to toggle button visibility
        window.addEventListener('scroll', this.toggleButton);

        // Initial call to toggle button visibility on page load
        this.toggleButton();
    }

    disconnect() {
        // Remove scroll event listener when controller is disconnected
        window.removeEventListener('scroll', this.toggleButton);
    }

    toggleButton() {
        // Show the button when the page is scrolled down, hide when at the top
        if (window.scrollY > 0) {
            this.buttonTarget.style.display = 'block';
        } else {
            this.buttonTarget.style.display = 'none';
        }
    }

    scrollToTop() {
        // Smooth scrolling to the top of the page
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}
