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
        const buttons = {
            fr: {
                active: this.frenchButtonTarget,
                inactive: this.englishButtonTarget
            },
            en: {
                active: this.englishButtonTarget,
                inactive: this.frenchButtonTarget
            }
        };

        buttons[language].active.classList.add('inactive');
        buttons[language].inactive.classList.remove('inactive');
    }
}