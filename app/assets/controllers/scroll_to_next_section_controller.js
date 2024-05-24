import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['button'];

    connect() {
        this.handleScroll = this.handleScroll.bind(this);
        this.scrollToNextSection = this.scrollToNextSection.bind(this);

        window.addEventListener('scroll', this.handleScroll);

        this.handleScroll(); // Initial call to handle scroll state on page load
    }

    disconnect() {
        // Remove scroll event listener on disconnect
        window.removeEventListener('scroll', this.handleScroll);
    }

    handleScroll() {
        const marginPixels = 50;
        const isCloseToBottom = (window.innerHeight + window.scrollY + marginPixels) >= document.body.offsetHeight;

        if (this.buttonTargets.length > 0) {
            const lastButton = this.buttonTargets[this.buttonTargets.length - 1];

            if (isCloseToBottom) {
                // Rotate button up if close to bottom
                this.addRotateUpKeyframes();
                lastButton.style.animation = 'rotateBtnUp 0.5s forwards';
                lastButton.style.transform = 'rotate(180deg)';
            } else {
                // Reset styles if not close to bottom
                lastButton.style.animation = '';
                lastButton.style.transform = 'rotate(0deg)';
            }
        }
    }

    scrollToNextSection(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const marginPixels = 50;
        const isCloseToBottom = (window.innerHeight + window.scrollY + marginPixels) >= document.body.offsetHeight;
        const lastButton = this.buttonTargets[this.buttonTargets.length - 1];

        if (isCloseToBottom) {
            // Scroll to top if close to bottom
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        } else {
            // Scroll to the target section
            const targetElement = document.querySelector(button.getAttribute('data-target'));
            const headerHeight = document.querySelector('.header') ? document.querySelector('.header').offsetHeight : 0;
            const targetPosition = targetElement.getBoundingClientRect().top + window.scrollY - headerHeight;

            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    }

    addRotateUpKeyframes() {
        // Define and insert keyframes for the rotate up animation
        const styleSheet = document.styleSheets[0];
        const keyframes = `
            @keyframes rotateBtnUp {
                from {
                    transform: rotate(0deg);
                }
                to {
                    transform: rotate(180deg);
                }
            }
        `;
        styleSheet.insertRule(keyframes, styleSheet.cssRules.length);
    }

    removeRotateUpKeyframes() {
        // Remove the rotate up keyframes from the stylesheet
        const styleSheet = document.styleSheets[0];
        for (let i = 0; i < styleSheet.cssRules.length; i++) {
            if (styleSheet.cssRules[i].name === 'rotateBtnUp') {
                styleSheet.deleteRule(i);
                break;
            }
        }
    }
}
