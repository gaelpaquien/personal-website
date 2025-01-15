import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["overlay", "reviewsPopup", "openButton", "closeButton"]
    static values = {
        scrollDelay: { type: Number, default: 250 },
        zIndexActive: { type: Number, default: 1 },
        zIndexInactive: { type: Number, default: 1000 }
    }

    initialize() {
        this.handleAnimationEnd = this.handleAnimationEnd.bind(this);
        this.handleOutsideClick = this.handleOutsideClick.bind(this);
    }

    connect() {
        this.header = document.querySelector('header');
        this.overlayTarget.addEventListener('click', this.handleOutsideClick);
    }

    disconnect() {
        this.removeEventListeners();
    }

    removeEventListeners() {
        this.overlayTarget?.removeEventListener('click', this.handleOutsideClick);
        this.reviewsPopupTarget?.removeEventListener('animationend', this.handleAnimationEnd);
    }

    open() {
        const targetElement = document.querySelector('#home-reviews');
        if (!targetElement) return;

        this.scrollToSection(targetElement);
        this.schedulePopupOpen();
    }

    scrollToSection(targetElement) {
        const targetPosition = targetElement.getBoundingClientRect().top +
            window.scrollY -
            this.header.offsetHeight;

        window.scrollTo({
            top: targetPosition,
            behavior: "smooth"
        });
    }

    schedulePopupOpen() {
        setTimeout(() => this.openPopup(), this.scrollDelayValue);
    }

    openPopup() {
        this.reviewsPopupTarget.style.display = 'block';
        this.reviewsPopupTarget.classList.add('popup-open-effects');
        this.overlayTarget.style.display = 'block';

        this.updatePageState(true);
        this.reviewsPopupTarget.addEventListener(
            'animationend',
            () => this.reviewsPopupTarget.classList.remove('popup-open-effects'),
            { once: true }
        );
    }

    close() {
        this.reviewsPopupTarget.classList.add('popup-close-effects');
        this.overlayTarget.style.display = 'none';

        this.reviewsPopupTarget.addEventListener(
            'animationend',
            this.handleAnimationEnd,
            { once: true }
        );
    }

    updatePageState(isOpen) {
        this.header.style.zIndex = isOpen ?
            this.zIndexActiveValue.toString() :
            this.zIndexInactiveValue.toString();
        document.body.style.overflow = isOpen ? 'hidden' : 'auto';
        this.openButtonTarget.setAttribute('aria-expanded', isOpen.toString());
    }

    handleAnimationEnd = () => {
        this.reviewsPopupTarget.style.display = 'none';
        this.reviewsPopupTarget.classList.remove('popup-close-effects');
        this.updatePageState(false);
    }

    handleOutsideClick = (event) => {
        if (event.target === this.overlayTarget) {
            this.close();
        }
    }
}