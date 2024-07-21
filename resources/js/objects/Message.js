class Message {
    /**
     * 
     * @param {String} contenu 
     * @param {Number} consultationId 
     * @param {Number} destinataire 
     * @param {Number} envoyeur_id 
     * @param {String} envoyeur_type 
     */
    constructor(contenu, consultationId, destinataire, envoyeur_id, envoyeur_type) {
        this.contenu = contenu
        this.consultationId = consultationId
        this.destinataire = destinataire
        this.envoyeur_id = envoyeur_id
        this.envoyeur_type = envoyeur_type
    }
}