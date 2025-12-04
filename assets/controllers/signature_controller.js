import {Controller} from "@hotwired/stimulus";
import SignaturePad from "signature_pad";

export default class extends Controller {
    static targets = [ "canvas" ]
    connect() {
        const pad = new SignaturePad(this.canvasTarget);
    }
}


