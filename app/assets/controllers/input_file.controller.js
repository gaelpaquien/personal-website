import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['input', 'filesContainer']
    static values = {
        chooseFile: String,
        noFileChosen: String,
        oneFileSelected: String,
        multipleFilesSelected: String,
    }

    connect() {
        this.files = new DataTransfer()
        this.customizeFileInput()
    }

    customizeFileInput() {
        if (!this.hasInputTarget) return
        this.inputTarget.setAttribute('multiple', 'multiple')

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

        const filesContainer = document.createElement('div')
        filesContainer.className = 'files-container'
        filesContainer.setAttribute('data-input-file-target', 'filesContainer')
        this.inputTarget.parentNode.insertBefore(filesContainer, this.inputTarget.nextSibling)

        this.inputTarget.style.opacity = 0
        this.inputTarget.style.position = 'absolute'
        this.inputTarget.style.pointerEvents = 'none'

        customButton.addEventListener('click', () => {
            this.inputTarget.click()
        })

        this.inputTarget.addEventListener('change', this.handleFileSelection.bind(this))

        this.fileNameLabel = fileNameLabel
    }

    handleFileSelection() {
        Array.from(this.inputTarget.files).forEach(file => {
            this.files.items.add(file)
        })

        this.updateInputFiles()

        this.updateFilesDisplay()
    }

    updateInputFiles() {
        this.inputTarget.files = this.files.files
    }

    updateFilesDisplay() {
        const fileCount = this.files.files.length
        if (fileCount > 0) {
            if (fileCount === 1) {
                this.fileNameLabel.textContent = `${fileCount} ${this.oneFileSelectedValue}`
            } else {
                this.fileNameLabel.textContent = `${fileCount} ${this.multipleFilesSelectedValue}`
            }

        } else {
            this.fileNameLabel.textContent = this.noFileChosenValue
        }

        if (this.hasFilesContainerTarget) {
            this.filesContainerTarget.innerHTML = ''

            Array.from(this.files.files).forEach(file => {
                const fileTag = document.createElement('div')
                fileTag.className = 'file-tag'

                const fileName = document.createElement('span')
                fileName.className = 'file-tag-name'
                fileName.textContent = file.name

                const removeBtn = document.createElement('span')
                removeBtn.className = 'file-tag-remove'
                removeBtn.innerHTML = '&times;'
                removeBtn.setAttribute('data-filename', file.name)
                removeBtn.addEventListener('click', this.removeFile.bind(this))

                fileTag.appendChild(fileName)
                fileTag.appendChild(removeBtn)
                this.filesContainerTarget.appendChild(fileTag)
            })
        }
    }

    removeFile(event) {
        const fileName = event.currentTarget.getAttribute('data-filename')
        const newFiles = new DataTransfer()

        Array.from(this.files.files)
            .filter(file => file.name !== fileName)
            .forEach(file => newFiles.items.add(file))

        this.files = newFiles

        this.updateInputFiles()
        this.updateFilesDisplay()
    }
}