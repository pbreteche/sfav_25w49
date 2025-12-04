import {Controller} from "@hotwired/stimulus";
import SignaturePad from "signature_pad";

export default class extends Controller {
    static targets = [ "canvas" ]
    connect() {
        this.pad = new SignaturePad(this.canvasTarget);
    }

    clear() {
        this.pad.clear();
    }
}


