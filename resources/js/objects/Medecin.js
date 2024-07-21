class Medecin {
    /**
     * @param {Number} id
     * @param {String} nom 
     * @param {String} prenom 
     * @param {String} email 
     * @param {String} password 
     * @param {Date} dateNaissance 
     * @param {Boolean} genre 
     * @param {String} adresse 
     * @param {String} telephone 
     * @param {String} hopital 
     * @param {String} specialite 
     */
    constructor(id, nom, prenom, email, password, dateNaissance, genre, adresse, telephone, hopital, specialite) {
        this.id = id
        this.nom = nom
        this.prenom = prenom
        this.email = email
        this.password = password
        this.dateNaissance = dateNaissance
        this.genre = genre
        this.adresse = adresse
        this.telephone = telephone
        this.hopital = hopital
        this.specialite = specialite
    }
}