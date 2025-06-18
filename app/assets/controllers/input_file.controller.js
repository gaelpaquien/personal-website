import { Controller } from '@hotwired/stimulus'

export default class extends Controller {
    static targets = ['input', 'display', 'filesContainer']
    static values = {
        chooseFile: String,
        noFileChosen: String,
        oneFileSelected: String,
        multipleFilesSelected: String,
        duplicateMessage: String,
        limitMessage: String,
        successMessage: String
    }

    connect() {
        this.files = new DataTransfer()
        this.fileIds = new Set()
        this.setupFileInput()
    }

    setupFileInput() {
        if (!this.hasInputTarget) return

        const customButton = this.element.querySelector('.custom-file-button')

        if (customButton) {
            customButton.addEventListener('click', (e) => {
                e.preventDefault()
                this.inputTarget.click()
            })
        }

        this.inputTarget.addEventListener('change', this.handleFileSelection.bind(this))
    }

    handleFileSelection(event) {
        Array.from(event.target.files).forEach(file => {
            const fileId = `${file.name}-${file.size}-${file.lastModified}`

            if (this.fileIds.has(fileId)) {
                window.Toast.error(this.duplicateMessageValue)
            } else if (this.files.files.length >= 3) {
                window.Toast.error(this.limitMessageValue)
            } else {
                this.files.items.add(file)
                this.fileIds.add(fileId)
            }
        })

        this.updateFilesDisplay()
        event.target.value = ''
    }

    updateFilesDisplay() {
        const fileCount = this.files.files.length

        if (this.hasDisplayTarget) {
            if (fileCount > 0) {
                if (fileCount === 1) {
                    this.displayTarget.textContent = `${fileCount} ${this.oneFileSelectedValue}`
                } else {
                    this.displayTarget.textContent = `${fileCount} ${this.multipleFilesSelectedValue}`
                }
            } else {
                this.displayTarget.textContent = this.noFileChosenValue
            }
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
                removeBtn.setAttribute('data-file-id', `${file.name}-${file.size}-${file.lastModified}`)
                removeBtn.addEventListener('click', this.removeFile.bind(this))

                fileTag.appendChild(fileName)
                fileTag.appendChild(removeBtn)
                this.filesContainerTarget.appendChild(fileTag)
            })
        }
    }

    removeFile(event) {
        const fileId = event.currentTarget.getAttribute('data-file-id')
        const newFiles = new DataTransfer()

        Array.from(this.files.files)
            .filter(file => `${file.name}-${file.size}-${file.lastModified}` !== fileId)
            .forEach(file => newFiles.items.add(file))

        this.files = newFiles
        this.fileIds.delete(fileId)
        this.updateFilesDisplay()
    }

    reset() {
        this.files = new DataTransfer()
        this.fileIds = new Set()
        this.updateFilesDisplay()
    }

    getFiles() {
        return this.files.files
    }
}