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
        this.preventHorizontalScroll = this.preventHorizontalScroll.bind(this);
        this.handleResize = this.handleResize.bind(this);
    }

    connect() {
        this.header = document.querySelector(this.headerSelectorValue);
        this.footer = document.querySelector('footer');
        window.addEventListener('scroll', this.debouncedScroll);
        window.addEventListener('scroll', this.preventHorizontalScroll);
        window.addEventListener('resize', this.handleResize);
        this.handleScroll();

        if (this.hasScrollTopButtonTarget) {
            this.setupBodyObserver();
        }
    }

    disconnect() {
        window.removeEventListener('scroll', this.debouncedScroll);
        window.removeEventListener('scroll', this.preventHorizontalScroll);
        window.removeEventListener('resize', this.handleResize);

        if (this.bodyObserver) {
            this.bodyObserver.disconnect();
        }
    }

    setupBodyObserver() {
        const mainElement = document.querySelector('main');
        if (mainElement) {
            this.bodyObserver = new MutationObserver(() => {
                if (this.hasScrollTopButtonTarget) {
                    const wasVisible = this.scrollTopButtonTarget.classList.contains(this.showClassValue);
                    if (wasVisible) {
                        this.scrollTopButtonTarget.style.transition = 'none';
                        this.scrollTopButtonTarget.style.opacity = '0';
                    }

                    setTimeout(() => {
                        this.handleScroll();
                        if (wasVisible) {
                            requestAnimationFrame(() => {
                                this.scrollTopButtonTarget.style.transition = '';
                                this.scrollTopButtonTarget.style.opacity = '';
                            });
                        }
                    }, 300);
                }
            });

            this.bodyObserver.observe(mainElement, {
                attributes: true,
                attributeFilter: ['style']
            });
        }
    }

    handleResize() {
        this.handleScroll();
    }

    preventHorizontalScroll() {
        if (window.scrollX !== 0) {
            window.scrollTo(0, window.scrollY);
        }
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
                const margin = 0.25 * remUnit;
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
                const wasBottom = button.dataset.isBottom === 'true';
                button.dataset.isBottom = isBottom.toString();

                if (isBottom) {
                    if (!wasBottom) {
                        button.classList.remove('rotate-down-effects');
                        button.classList.add('rotate-up-effects');
                    }
                    button.dataset.action = 'click->scroll#scrollToTop';
                } else {
                    if (wasBottom) {
                        button.classList.remove('rotate-up-effects');
                        button.classList.add('rotate-down-effects');

                        setTimeout(() => {
                            button.classList.remove('rotate-down-effects');
                        }, 500);
                    }
                    button.dataset.action = 'click->scroll#scrollToSection';
                }
            });
        }
    }

    scrollToTop(event) {
        if (event) event.preventDefault();

        const targetY = 0;
        const currentY = window.scrollY;

        if (currentY > 0) {
            window.scrollTo({
                top: targetY,
                left: 0,
                behavior: 'smooth'
            });
        }
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
            left: 0,
            behavior: 'smooth'
        });
    }
}