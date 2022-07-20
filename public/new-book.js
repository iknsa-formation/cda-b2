const updateAuthors = function () {
    /** @todo delete all childre from element */
    const element = document.getElementById('new_book_authors');

    let counter = 0;

    const createFieldElement = function () {
        counter++;
        let newField = element.dataset.prototype
            .replaceAll('__name__label__', 'Author ' + counter)
            .replaceAll('__name__', counter);

        const deleteFieldButton = `<span class="btn btn-danger delete-field" data-field-id="${counter}">
                            Remove author ${counter}</span>`;

        newField += deleteFieldButton;
        element.insertAdjacentHTML('beforeend', newField);
    }

    if (!document.getElementById('new-book-button')) {
        const addNewButtonTemplate = `<button class="btn btn-primary" id="new-book-button">Ajouter un auteur</button>`;
        element.insertAdjacentHTML('afterend', addNewButtonTemplate);

        const addNewButton = document.getElementById('new-book-button');

        addNewButton.addEventListener('click', function (event) {
            event.preventDefault();

            createFieldElement();

            const deleteButtons = document.getElementsByClassName('delete-field');

            Array.from(deleteButtons).forEach(button => {
                button.addEventListener('click', function (event) {
                    this.previousSibling.remove()
                    this.remove();
                })
            });
        })
    }

    if (!element.childElementCount) {
        createFieldElement();
    }
}

updateAuthors();

const languageField = document.getElementById('new_book_language');

languageField.addEventListener('change', (event) => {
    let data = new FormData;
    data.append(event.target.name, event.target.value);

    fetch(window.location.href, { method: "POST", body: data })
        .then(function (response) {
            response.text()
                .then(html => {
                    const parser = new DOMParser();
                    const page = parser.parseFromString(html, "text/html");

                    const element = page.getElementById('new_book_authors');
                    document.getElementById('new_book_authors').dataset.prototype = element.dataset.prototype;

                    updateAuthors();
                })
        });
});