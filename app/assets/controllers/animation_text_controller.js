import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['text'];
    static values = {
        delay: { type: Number, default: 20 },
        initialDelay: { type: Number, default: 100 },
        staggerDelay: { type: Number, default: 150 }
    }

    connect() {
        setTimeout(() => this.animateText(), 50);
    }

    animateText() {
        this.textTargets.forEach((element, index) => {
            if (!element.dataset.originalText) {
                element.dataset.originalText = element.textContent.trim();
            }

            const titleDelay = index === 0 ? this.initialDelayValue : this.initialDelayValue + this.staggerDelayValue;

            setTimeout(() => {
                this.animateTitle(element, index);
            }, titleDelay);
        });
    }

    animateTitle(element, elementIndex) {
        const text = element.dataset.originalText || element.textContent.trim();

        if (!text) return;

        element.textContent = '';
        element.style.opacity = 1;

        const words = text.split(' ');
        const baseDelay = elementIndex === 0 ? 35 : 25;

        words.forEach((word, wordIndex) => {
            const wordSpan = document.createElement('span');
            wordSpan.style.display = 'inline-block';
            wordSpan.style.marginRight = '0.3em';
            element.appendChild(wordSpan);

            [...word].forEach((char, charIndex) => {
                const span = document.createElement('span');
                span.textContent = char;
                span.style.opacity = 0;
                span.style.display = 'inline-block';

                if (elementIndex === 0) {
                    span.style.transform = 'translateY(15px)';
                    span.style.transition = `opacity 0.35s ease, transform 0.35s cubic-bezier(0.175, 0.885, 0.32, 1.275)`;
                } else {
                    span.style.transform = 'translateX(10px)';
                    span.style.transition = `opacity 0.3s ease-out, transform 0.3s ease-out`;
                }

                wordSpan.appendChild(span);

                const delay = (wordIndex * 2 + charIndex) * baseDelay;
                setTimeout(() => {
                    span.style.opacity = 1;
                    span.style.transform = 'translate(0)';
                }, delay);
            });
        });
    }
}