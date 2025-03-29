import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['input']
    static values = {
        chooseFile: String,
        noFileChosen: String
    }

    connect() {
        this.customizeFileInput()
    }

    customizeFileInput() {
        if (!this.hasInputTarget) return

        const wrapper = document.createElement('div')
        wrapper.className = 'custom-file-input-wrapper'

        const customButton = document.createElement('span')
        customButton.className = 'custom-file-button btn'
        customButton.textContent = this.chooseFileValue

        const fileNameLabel = document.createElement('span')
        fileNameLabel.className = 'custom-file-name'
        fileNameLabel.textContent = this.noFileChosenValue

        wrapper.appendChild(customButton)
        wrapper.appendChild(fileNameLabel)

        this.inputTarget.parentNode.insertBefore(wrapper, this.inputTarget)

        this.inputTarget.style.opacity = 0
        this.inputTarget.style.position = 'absolute'
        this.inputTarget.style.pointerEvents = 'none'

        customButton.addEventListener('click', () => {
            this.inputTarget.click()
        })

        this.inputTarget.addEventListener('change', () => {
            if (this.inputTarget.files.length > 0) {
                fileNameLabel.textContent = this.inputTarget.files[0].name
            } else {
                fileNameLabel.textContent = this.noFileChosenValue
            }
        })
    }
}