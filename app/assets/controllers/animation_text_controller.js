import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['text'];
    static values = {
        delay: { type: Number, default: 20 },
        initialDelay: { type: Number, default: 100 },
        staggerDelay: { type: Number, default: 150 }
    }

    connect() {
        requestAnimationFrame(() => {
            requestAnimationFrame(() => {
                this.animateText();
            });
        });
    }

    animateText() {
        const fragment = document.createDocumentFragment();
        const animations = [];

        this.textTargets.forEach((element, index) => {
            if (!element.dataset.originalText) {
                element.dataset.originalText = element.textContent.trim();
            }

            const titleDelay = index === 0 ? this.initialDelayValue : this.initialDelayValue + this.staggerDelayValue;
            animations.push({ element, index, delay: titleDelay });
        });

        animations.forEach(({ element, index, delay }) => {
            setTimeout(() => {
                this.animateTitle(element, index);
            }, delay);
        });
    }

    animateTitle(element, elementIndex) {
        const text = element.dataset.originalText || element.textContent.trim();
        if (!text) return;

        const fragment = document.createDocumentFragment();
        const words = text.split(' ');
        const baseDelay = elementIndex === 0 ? 45 : 35;
        const spans = [];

        words.forEach((word, wordIndex) => {
            const wordSpan = document.createElement('span');
            wordSpan.style.cssText = 'display: inline-block; margin-right: 0.3em;';

            [...word].forEach((char, charIndex) => {
                const span = document.createElement('span');
                span.textContent = char;

                const isFirstElement = elementIndex === 0;
                const transform = isFirstElement ? 'translateY(15px)' : 'translateX(10px)';
                const timing = isFirstElement
                    ? 'cubic-bezier(0.175, 0.885, 0.32, 1.275)'
                    : 'ease-out';
                const duration = isFirstElement ? '0.35s' : '0.3s';

                span.style.cssText = `
                    opacity: 0;
                    display: inline-block;
                    transform: ${transform};
                    transition: opacity ${duration} ${timing}, transform ${duration} ${timing};
                    will-change: transform, opacity;
                `;

                wordSpan.appendChild(span);

                const delay = (wordIndex * 2 + charIndex) * baseDelay;
                spans.push({ span, delay });
            });

            fragment.appendChild(wordSpan);
        });

        element.textContent = '';
        element.style.opacity = '1';
        element.appendChild(fragment);

        this.animateSpans(spans);
    }

    animateSpans(spans) {
        const animationGroups = new Map();

        spans.forEach(({ span, delay }) => {
            if (!animationGroups.has(delay)) {
                animationGroups.set(delay, []);
            }
            animationGroups.get(delay).push(span);
        });

        animationGroups.forEach((groupSpans, delay) => {
            setTimeout(() => {
                requestAnimationFrame(() => {
                    groupSpans.forEach(span => {
                        span.style.opacity = '1';
                        span.style.transform = 'translate(0)';
                    });
                });
            }, delay);
        });
    }
}