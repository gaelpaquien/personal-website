import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['button'];

    connect() {
        this.toggleButton = this.toggleButton.bind(this);

        window.addEventListener('scroll', this.toggleButton);

        this.toggleButton(); // Initial call to toggle button visibility on page load
    }

    disconnect() {
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
