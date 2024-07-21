export default class FicheConsultation {
    /**
     * 
     * @param {Number} temperature 
     * @param {String} typeMaladie 
     * @param {String} descriptionMaladie 
     * @param {String} antecedentMedicaux 
     * @param {String} traitementIntial
     * @param {String} groupeSangin
     */
    constructor(temperature, typeMaladie, descriptionMaladie, antecedentMedicaux, traitementIntial, groupeSangin) {
        this.temperature = temperature
        this.typeMaladie = typeMaladie
        this.descriptionMaladie = descriptionMaladie
        this.antecedentMedicaux = antecedentMedicaux
        this.traitementIntial = traitementIntial
        this.groupeSangin = groupeSangin
    }
}