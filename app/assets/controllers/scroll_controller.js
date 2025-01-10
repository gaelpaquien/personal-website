import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['scrollTopButton', 'sectionButton', 'title']
    static values = {
        margin: { type: Number, default: 50 },
        headerSelector: { type: String, default: '.header' },
        scrollThreshold: { type: Number, default: 100 },
        showClass: { type: String, default: 'visible' }
    }

    initialize() {
        this.handleScroll = this.handleScroll.bind(this);
    }

    connect() {
        this.header = document.querySelector(this.headerSelectorValue);
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
        if (this.hasScrollTopButtonTarget) {
            const shouldShow = window.scrollY > this.scrollThresholdValue;
            this.toggleScrollTopButton(shouldShow);
        }

        if (this.hasSectionButtonTarget) {
            const lastButton = this.sectionButtonTargets[this.sectionButtonTargets.length - 1];
            lastButton.classList.toggle('rotate-up-effects', this.isCloseToBottom());
        }
    }

    scrollToTop() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    scrollToSection(event) {
        event.preventDefault();

        if (this.isCloseToBottom() && event.currentTarget.hasAttribute('data-section-button')) {
            this.scrollToTop();
            return;
        }

        const targetId = this.getTargetId(event);
        if (!targetId) return;

        const targetElement = document.querySelector(`#${targetId}`);
        if (!targetElement) {
            console.warn(`Element with ID ${targetId} not found.`);
            return;
        }

        this.smoothScrollTo(targetElement);
    }

    isCloseToBottom() {
        return (window.innerHeight + window.scrollY + this.marginValue) >=
            document.documentElement.scrollHeight;
    }

    toggleScrollTopButton(show) {
        this.scrollTopButtonTarget.classList.toggle(this.showClassValue, show);
    }

    getTargetId(event) {
        return event.currentTarget.getAttribute('data-target')?.replace('#', '');
    }

    smoothScrollTo(element) {
        const headerOffset = this.header?.offsetHeight || 0;
        const targetPosition = element.getBoundingClientRect().top +
            window.scrollY -
            headerOffset;

        window.scrollTo({
            top: targetPosition,
            behavior: 'smooth'
        });
    }
}