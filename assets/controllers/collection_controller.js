import { Controller } from '@hotwired/stimulus';

export default class extends Controller {

    container;
    template;

    connect() 
    {
        this.container = this.element.querySelector('[data-collection-id]');
    }

    getTemplate() 
    {
        this.template = this.element.querySelector('template');

        if (this.template)
        {
            var clone = document.importNode(this.template.content, true);
            this.container.appendChild( clone );
        }
    }
}
