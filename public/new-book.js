if (document.getElementById('new_book_authors')) {
    const element = document.getElementById('new_book_authors');
    const prototype = element.dataset.prototype;
    const addNewButtonTemplate = `<button class="btn btn-primary" id="new-book-button">Ajouter un auteur</button>`;
    let counter = 0;

    element.insertAdjacentHTML('afterend', addNewButtonTemplate);

    const createFieldElement = function () {
        counter++;
        let newField = prototype
            .replaceAll('__name__label__', 'Author ' + counter)
            .replaceAll('__name__', counter);

        const deleteFieldButton = `<span class="btn btn-danger delete-field" data-field-id="${counter}">
                                Remove author ${counter}</span>`;

        newField += deleteFieldButton;
        element.insertAdjacentHTML('beforeend', newField);
    }

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

    if (!element.childElementCount) {
        createFieldElement();
    }
}



const languageField = document.getElementById('new_book_language');

languageField.addEventListener('change', (event) => {
    const tokenElement = document.getElementById('new_book__token');

    let data = new FormData;
    data.append(event.target.name, event.target.value);

    fetch(window.location.href, { method: "POST", body: data })
        .then(function (response) {
            response.text()
        });
});