export default class Ordonnance {
    /**
     * 
     * @param {String} medicament 
     * @param {String} modeEmploi 
     * @param {Number} quantite 
     */
    constructor(medicament, modeEmploi, quantite) {
        this.medicament = medicament
        this.modeEmploi = modeEmploi
        this.quantite = quantite
    }
}