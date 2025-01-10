import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['title']
    static values = {
        headerSelector: { type: String, default: '.header' }
    }

    initialize() {
        this.scrollToSection = this.scrollToSection.bind(this);
    }

    connect() {
        this.header = document.querySelector(this.headerSelectorValue);
    }

    scrollToSection(event) {
        event.preventDefault();

        const targetId = this.getTargetId(event);
        if (!targetId) return;

        const targetElement = document.querySelector(`#${targetId}`);
        if (!targetElement) {
            console.warn(`Element with ID ${targetId} not found.`);
            return;
        }

        this.smoothScrollTo(targetElement);
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