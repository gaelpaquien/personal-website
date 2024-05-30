import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["overlay", "reviewsPopup", "openButton", "closeButton"];

    connect() {
        this.header = document.querySelector('header');
        this.overlayTarget.addEventListener('click', this.handleOutsideClick);
    }

    disconnect() {
        this.overlayTarget.removeEventListener('click', this.handleOutsideClick);
    }

    open() {
        const targetElement = document.querySelector('#home-reviews');

        // Scroll to the reviews section smoothly
        const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - this.header.offsetHeight;
        window.scrollTo({
            top: targetPosition,
            behavior: "smooth"
        });

        // Delay the popup display and animation for smooth scrolling
        setTimeout(() => {
            this.reviewsPopupTarget.style.display = 'block';
            this.reviewsPopupTarget.classList.add('popup-open-effects');
            this.overlayTarget.style.display = 'block';
            this.header.style.zIndex = '1';
            document.body.style.overflow = 'hidden';
            this.openButtonTarget.setAttribute('aria-expanded', 'true');

            // Cleanup after the animation ends
            this.reviewsPopupTarget.addEventListener('animationend', () => {
                this.reviewsPopupTarget.classList.remove('popup-open-effects');
            }, { once: true });
        }, 250);
    }

    close() {
        this.reviewsPopupTarget.classList.add('popup-close-effects');
        this.overlayTarget.style.display = 'none';

        // Cleanup after the animation ends
        this.reviewsPopupTarget.addEventListener('animationend', () => {
            this.reviewsPopupTarget.style.display = 'none';
            this.reviewsPopupTarget.classList.remove('popup-close-effects');
            this.header.style.zIndex = '1000';
            document.body.style.overflow = 'auto';
            this.openButtonTarget.setAttribute('aria-expanded', 'false');
        }, { once: true });
    }

    handleOutsideClick = (event) => {
        if (event.target === this.overlayTarget) {
            this.close();
        }
    }
}
