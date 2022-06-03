import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    template;

    connect() {
    }

    getTemplate() 
    {
        this.template = this.element.querySelector('template');

        console.log(this.template);
    }
}
