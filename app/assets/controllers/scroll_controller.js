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
        this.debouncedScroll = this.debounce(this.handleScroll.bind(this), 5);
    }

    connect() {
        this.header = document.querySelector(this.headerSelectorValue);
        this.footer = document.querySelector('footer');
        window.addEventListener('scroll', this.debouncedScroll);
        this.handleScroll();
    }

    disconnect() {
        window.removeEventListener('scroll', this.debouncedScroll);
    }

    debounce(func, wait) {
        let timeout;
        return () => {
            clearTimeout(timeout);
            timeout = setTimeout(func, wait);
        };
    }

    handleScroll() {
        const scrollY = window.scrollY || window.pageYOffset;

        if (this.hasScrollTopButtonTarget) {
            const shouldShow = scrollY > this.scrollThresholdValue;
            this.scrollTopButtonTarget.classList.toggle(this.showClassValue, shouldShow);

            if (this.footer && shouldShow) {
                const footerTop = this.footer.getBoundingClientRect().top;
                const viewportHeight = window.innerHeight;
                const buttonHeight = this.scrollTopButtonTarget.offsetHeight;
                const remUnit = parseFloat(getComputedStyle(document.documentElement).fontSize);
                const margin = 0.75 * remUnit;
                const normalBottom = margin;

                if (footerTop < viewportHeight) {
                    const newBottom = viewportHeight - footerTop + margin;
                    this.scrollTopButtonTarget.style.position = 'absolute';
                    this.scrollTopButtonTarget.style.bottom = 'auto';
                    this.scrollTopButtonTarget.style.top = `${window.scrollY + footerTop - buttonHeight - margin}px`;
                } else {
                    this.scrollTopButtonTarget.style.position = 'fixed';
                    this.scrollTopButtonTarget.style.top = 'auto';
                    this.scrollTopButtonTarget.style.bottom = `${normalBottom}px`;
                }
            }
        }

        if (this.hasSectionButtonTarget) {
            const isBottom = this.isCloseToBottom();
            this.sectionButtonTargets.forEach(button => {
                button.dataset.isBottom = isBottom.toString();
                if (isBottom) {
                    button.dataset.action = 'click->scroll#scrollToTop';
                    button.classList.add('rotate-up-effects');
                } else {
                    button.dataset.action = 'click->scroll#scrollToSection';
                    button.classList.remove('rotate-up-effects');
                }
            });
        }
    }

    scrollToTop(event) {
        if (event) event.preventDefault();
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    }

    scrollToSection(event) {
        event.preventDefault();
        const button = event.currentTarget;

        if (button.dataset.isBottom === 'true') {
            this.scrollToTop();
            return;
        }

        const targetId = this.getTargetId(event);
        if (!targetId) return;

        const targetElement = document.querySelector(`#${targetId}`);
        if (!targetElement) return;

        this.smoothScrollTo(targetElement);
    }

    isCloseToBottom() {
        const windowHeight = window.innerHeight;
        const documentHeight = document.documentElement.scrollHeight;
        const scrollPosition = window.scrollY || window.pageYOffset;
        return windowHeight + scrollPosition + this.marginValue >= documentHeight;
    }

    getTargetId(event) {
        return event.currentTarget.getAttribute('data-target')?.replace('#', '');
    }

    smoothScrollTo(element) {
        const headerOffset = this.header?.offsetHeight || 0;
        const elementPosition = element.getBoundingClientRect().top;
        const offsetPosition = elementPosition + window.pageYOffset - headerOffset;

        window.scrollTo({
            top: offsetPosition,
            behavior: 'smooth'
        });
    }
}