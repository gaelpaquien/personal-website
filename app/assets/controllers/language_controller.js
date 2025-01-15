import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ["frenchButton", "englishButton"]
    static values = {
        defaultLanguage: { type: String, default: 'fr' }
    }

    connect() {
        this.applyLanguage();
    }

    toggleLanguage(event) {
        const language = event.currentTarget.dataset.language;
        localStorage.setItem('language', language);
        this.updateButtonState(language);
    }

    applyLanguage() {
        const language = localStorage.getItem('language') || this.defaultLanguageValue;
        this.updateButtonState(language);
    }

    updateButtonState(language) {
        const frenchButtons = document.querySelectorAll('[data-language-target="frenchButton"]');
        const englishButtons = document.querySelectorAll('[data-language-target="englishButton"]');

        if (language === 'fr') {
            frenchButtons.forEach(button => button.classList.add('inactive'));
            englishButtons.forEach(button => button.classList.remove('inactive'));
        } else {
            englishButtons.forEach(button => button.classList.add('inactive'));
            frenchButtons.forEach(button => button.classList.remove('inactive'));
        }
    }
}