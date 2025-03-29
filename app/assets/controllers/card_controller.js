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
        const url = card.dataset.url;

        card.style.animation = `pressed ${this.durationValue}s ease forwards`;

        if (url) {
            setTimeout(() => {
                window.location.href = url;
            }, this.durationValue * 1000);
        }
    }

    resetAnimation = (event) => {
        event.currentTarget.style.animation = '';
    }
}