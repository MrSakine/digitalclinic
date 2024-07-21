export default class Patient {
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
     */
    constructor(id, nom, prenom, email, password, dateNaissance, genre, adresse, telephone) {
        this.id = id
        this.nom = nom
        this.prenom = prenom
        this.password = password
        this.email = email
        this.dateNaissance = dateNaissance
        this.genre = genre
        this.adresse = adresse
        this.telephone = telephone
    }

}