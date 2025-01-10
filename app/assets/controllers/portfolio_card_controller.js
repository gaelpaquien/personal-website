import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['card']
    static values = {
        scale: { type: Number, default: 0.95 },
        duration: { type: Number, default: 0.25 },
        url: String
    }

    connect() {
        this.cardTargets.forEach(card => {
            card.addEventListener('animationend', this.resetAnimation);
        });
    }

    disconnect() {
        this.cardTargets.forEach(card => {
            card.removeEventListener('animationend', this.resetAnimation);
        });
    }

    pressCard(event) {
        const card = event.currentTarget;
        card.style.animation = `pressed ${this.durationValue}s ease forwards`;

        if (this.hasUrlValue) {
            setTimeout(() => {
                window.location.href = this.urlValue;
            }, this.durationValue * 1000);
        }
    }

    resetAnimation = (event) => {
        event.currentTarget.style.animation = '';
    }
}