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

        this.addOpenKeyframes(); // Add keyframes for the open animation

        // Delay the popup display and animation for smooth scrolling
        setTimeout(() => {
            this.reviewsPopupTarget.style.display = 'block';
            this.reviewsPopupTarget.style.animation = 'popupOpen 0.5s ease-out forwards';
            this.overlayTarget.style.display = 'block';
            this.header.style.zIndex = '1';
            document.body.style.overflow = 'hidden';
            this.openButtonTarget.setAttribute('aria-expanded', 'true');

            // Cleanup after the animation ends
            this.reviewsPopupTarget.addEventListener('animationend', () => {
                this.reviewsPopupTarget.style.animation = '';
                this.removeOpenKeyframes(); // Remove the open keyframes
            }, { once: true });
        }, 250);
    }

    close() {
        this.addCloseKeyframes(); // Add keyframes for the close animation
        this.reviewsPopupTarget.style.animation = 'popupClose 0.5s ease-out forwards';
        this.overlayTarget.style.display = 'none';

        // Cleanup after the animation ends
        this.reviewsPopupTarget.addEventListener('animationend', () => {
            this.reviewsPopupTarget.style.display = 'none';
            this.reviewsPopupTarget.style.animation = '';
            this.header.style.zIndex = '1000';
            document.body.style.overflow = 'auto';
            this.openButtonTarget.setAttribute('aria-expanded', 'false');

            this.removeCloseKeyframes(); // Remove the close keyframes
        }, { once: true });
    }

    addOpenKeyframes() {
        // Define and insert keyframes for the open animation
        const styleSheet = document.styleSheets[0];
        const keyframes = `
            @keyframes popupOpen {
                0% {
                    opacity: 0.5;
                    transform: translate(-200%, 150%);
                }
                100% {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                }
            }
        `;
        styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
    }

    addCloseKeyframes() {
        // Define and insert keyframes for the close animation
        const styleSheet = document.styleSheets[0];
        const keyframes = `
            @keyframes popupClose {
                0% {
                    opacity: 1;
                    transform: translate(-50%, -50%);
                }
                100% {
                    opacity: 0;
                    transform: translate(-200%, 150%);
                }
            }
        `;
        styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
    }

    removeOpenKeyframes() {
        // Remove the open keyframes from the stylesheet
        const styleSheet = document.styleSheets[0];
        for (let i = 0; i < styleSheet.cssRules.length; i++) {
            if (styleSheet.cssRules[i].name === 'popupOpen') {
                styleSheet.deleteRule(i);
                break;
            }
        }
    }

    removeCloseKeyframes() {
        // Remove the close keyframes from the stylesheet
        const styleSheet = document.styleSheets[0];
        for (let i = 0; i < styleSheet.cssRules.length; i++) {
            if (styleSheet.cssRules[i].name === 'popupClose') {
                styleSheet.deleteRule(i);
                break;
            }
        }
    }

    handleOutsideClick = (event) => {
        if (event.target === this.overlayTarget) {
            this.close();
        }
    }
}
