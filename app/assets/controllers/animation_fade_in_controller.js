import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['fadeIn']
    static values = {
        margin: String,
        defaultAnimation: {type: String, default: 'fade-in-up-effects'}
    }

    connect() {
        const ROOT_MARGIN = this.marginValue || '0px 0px -20px 0px';

        this.observer = new IntersectionObserver(this.handleIntersection.bind(this), {
            threshold: 0.1,
            rootMargin: ROOT_MARGIN
        });

        this.fadeInTargets.forEach(element => {
            const animationClass = element.dataset.animation || this.defaultAnimationValue;
            element.classList.add(`${animationClass}-initial`);

            this.observer.observe(element);
        });
    }

    disconnect() {
        if (this.observer) {
            this.observer.disconnect();
        }
    }

    handleIntersection(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const animationClass = entry.target.dataset.animation || this.defaultAnimationValue;
                entry.target.classList.remove(`${animationClass}-initial`);
                entry.target.classList.add(animationClass);
                this.observer.unobserve(entry.target);
            }
        });
    }
}