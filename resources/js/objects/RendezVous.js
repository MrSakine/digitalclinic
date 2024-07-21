export default class RendezVous {
    /**
     * 
     * @param {String} typeConsultation 
     * @param {Date} dateConsultation 
     * @param {Double} prix 
     */
    constructor(typeConsultation, dateConsultation, prix) {
        this.typeConsultation = typeConsultation
        this.dateConsultation = dateConsultation
        this.prix = prix
    }
}