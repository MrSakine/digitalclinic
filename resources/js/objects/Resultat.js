import Ordonnace from './Ordonnance'

class Resultat {
    /**
     * 
     * @param {String} conseil 
     * @param {String} observation 
     * @param {String} diagnostic 
     * @param {Ordonnace} ordonnace
     */
    constructor(conseil, observation, diagnostic, ordonnace) {
        this.conseil = conseil
        this.observation = observation
        this.diagnostic = diagnostic
        this.ordonnace = ordonnace
    }
}

export default Resultat