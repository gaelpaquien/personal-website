import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['button']
    static values = {
        scrollThreshold: { type: Number, default: 100 },
        showClass: { type: String, default: 'visible' }
    }

    initialize() {
        this.handleScroll = this.handleScroll.bind(this);
    }

    connect() {
        this.setupEventListeners();
        requestAnimationFrame(() => this.handleScroll());
    }

    disconnect() {
        this.removeEventListeners();
    }

    setupEventListeners() {
        window.addEventListener('scroll', this.debouncedScroll.bind(this));
    }

    removeEventListeners() {
        window.removeEventListener('scroll', this.debouncedScroll.bind(this));
    }

    debouncedScroll() {
        if (this.scrollTimeout) {
            window.cancelAnimationFrame(this.scrollTimeout);
        }
        this.scrollTimeout = window.requestAnimationFrame(() => this.handleScroll());
    }

    handleScroll() {
        if (!this.hasButtonTarget) return;

        const shouldShow = window.scrollY > this.scrollThresholdValue;
        this.toggleButtonVisibility(shouldShow);
    }

    toggleButtonVisibility(show) {
        if (show) {
            this.buttonTarget.classList.add(this.showClassValue);
        } else {
            this.buttonTarget.classList.remove(this.showClassValue);
        }
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }
}