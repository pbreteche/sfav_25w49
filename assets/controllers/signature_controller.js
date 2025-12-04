import {Controller} from "@hotwired/stimulus";
import SignaturePad from "signature_pad";

export default class extends Controller {
    static targets = [ "canvas", "output", "submitButton"]
    static values = {floor: Number}
    connect() {
        this.pad = new SignaturePad(this.canvasTarget);
        this.submitButtonTarget.disabled = true;
        this.pad.addEventListener('endStroke', () => this.validate())
    }

    clear() {
        this.pad.clear();
        this.submitButtonTarget.disabled = true;
    }

    validate() {
        const points = this.pad.toData().reduce((prev, cur) => prev + cur.points.length, 0);
        this.submitButtonTarget.disabled = points < this.floorValue;
    }

    commit() {
        this.outputTarget.innerHTML = `<img src="${this.pad.toDataURL()}" alt="signature enregistrée">`;
    }
}
