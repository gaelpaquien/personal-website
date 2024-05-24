import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["frenchButton", "englishButton"]

    connect() {
        this.applyLanguage();
    }

    toggleLanguage(event) {
        // Set the language based on the clicked button's data-language attribute
        const language = event.currentTarget.dataset.language;
        localStorage.setItem('language', language);
        this.applyLanguage();
    }

    applyLanguage() {
        // // Retrieve the language from localStorage or default to 'fr'
        // const language = localStorage.getItem('language') || 'fr';

        // // Update the state of the language toggle buttons
        // this.updateButtonState();
    }

    updateButtonState() {
        // Update button states based on the current language
        const language = localStorage.getItem('language');
        if (language === 'fr') {
            this.frenchButtonTarget.classList.add('inactive');
            this.englishButtonTarget.classList.remove('inactive');
        } else {
            this.englishButtonTarget.classList.add('inactive');
            this.frenchButtonTarget.classList.remove('inactive');
        }
    }
}
