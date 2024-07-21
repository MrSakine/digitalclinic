export default class Consultation {
    /**
     * 
     * @param {String} typeConsultation 
     * @param {Number} prixConsultation 
     * @param {Boolean} payer 
     * @param {Boolean} valider 
     * @param {Date} dateValidation 
     * @param {FicheConsultation} ficheConsultation
     * @param {Number} id
     */
    constructor(id, typeConsultation, prixConsultation, payer, valider, dateCreation, dateValidation, ficheConsultation) {
        this.id = id
        this.typeConsultation = typeConsultation
        this.prixConsultation = prixConsultation
        this.payer = payer
        this.valider = valider
        this.dateCreation = dateCreation
        this.dateValidation = dateValidation
        this.ficheConsultation = ficheConsultation
    }
}