import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['fadeIn']
    static values = {
        margin: String,
        defaultAnimation: { type: String, default: 'fade-in-up-effects' },
        threshold: { type: Number, default: 0.15 }
    }

    connect() {
        this.fadeInTargets.forEach(element => {
            const animationClass = element.dataset.animation || this.defaultAnimationValue;
            element.classList.add(`${animationClass}-initial`);
            element.style.visibility = 'hidden';
        });

        this.setupObserver();

        requestAnimationFrame(() => {
            this.fadeInTargets.forEach(element => {
                element.style.visibility = 'visible';
                this.observer.observe(element);
            });
        });
    }

    setupObserver() {
        const ROOT_MARGIN = this.marginValue || '0px 0px -10px 0px';

        this.observer = new IntersectionObserver(this.handleIntersection.bind(this), {
            threshold: this.thresholdValue,
            rootMargin: ROOT_MARGIN
        });
    }

    disconnect() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }

    handleIntersection(entries) {
        const toAnimate = [];

        entries.forEach(entry => {
            if (entry.isIntersecting) {
                toAnimate.push(entry.target);
                this.observer.unobserve(entry.target);
            }
        });

        if (toAnimate.length > 0) {
            requestAnimationFrame(() => {
                toAnimate.forEach(element => {
                    const animationClass = element.dataset.animation || this.defaultAnimationValue;
                    element.classList.remove(`${animationClass}-initial`);
                    element.classList.add(animationClass);
                });
            });
        }
    }
}