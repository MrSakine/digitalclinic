<template>
    <div id="appHome">
        <nav-bar :faqActive="true" />
        <div class="section__faq-title">
            <h1>f.a.q</h1>
        </div>
    </div>
    <div id="section__faq">
        <div class="section__faq-main">
            <p>Je suis un médecin ou un futur médecin</p>
            <div class="section__faq-sub">
                <div>
                    <input type="checkbox" id="title1" class="accordion-input" />
                    <label for="title1" class="accordion-label">Comment se connecter en tant que médecin ?</label>
                    <div class="accordion-content">
                        <p>Utiliser votre email et votre mot de passe, vous serez redirigé vers la page pour les médecins après authentification</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title2" class="accordion-input" />
                    <label for="title2" class="accordion-label">Comment traiter les demandes de consultation ?</label>
                    <div class="accordion-content">
                        <p> Une fois sur la page d'accueil (après la connexion), aller sur l'onglet &laquo; Liste Consultations &raquo; qui vous montrera la liste des demandes de consultations re&ccedil;ues, cliquer sur le bouton "Traiter" sur une consultation
                            de la liste et suivez les étapes</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title3" class="accordion-input" />
                    <label for="title3" class="accordion-label">Comment communiquer avec les patients pour leur demander plus d'informations ?</label>
                    <div class="accordion-content">
                        <p> Après l'authentification, aller sur l'onglet &laquo; Messages &raquo; , cliquer sur le bouton "Dialoguer" en vert et valider</p>
                    </div>
                </div>
            </div>
            <p>Je suis un patient ou un futur patient</p>
            <div class=" section__faq-sub">
                <div>
                    <input type="checkbox" id="title4" class="accordion-input" />
                    <label for="title4" class="accordion-label">Comment faire pour créer un compte patient ?</label>
                    <div class="accordion-content">
                        <p> Utiliser la page d'inscription pour vous inscrire. Les informations à mettre sont: nom, prenom, date de naissance, genre, adresse, numéro de téléphone, email et mot de passe</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title5" class="accordion-input" />
                    <label for="title5" class="accordion-label">Comment se connecter en tant que patient ?</label>
                    <div class="accordion-content">
                        <p> Utiliser votre email et votre mot de passe pour vous connecter. Vous serez redirigé vers la page du patient après l'authentification</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title6" class="accordion-input" />
                    <label for="title6" class="accordion-label">Comment faire une demande de consultation en ligne ?</label>
                    <div class="accordion-content">
                        <p> Après l'authentification, aller sur l'onglet &laquo; Consultations &raquo; , cliquer sur le bouton "Ajouter" et suivez les étapes du formulaire</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title7" class="accordion-input" />
                    <label for="title7" class="accordion-label">Comment faire une demande de rendez-vous ?</label>
                    <div class="accordion-content">
                        <p> Après l'authentification, aller sur l'onglet &laquo; Rendez Vous &raquo; , cliquer sur le bouton "Ajouter" et suivez les étapes du formulaire</p>
                    </div>
                </div>
                <div>
                    <input type="checkbox" id="title8" class="accordion-input" />
                    <label for="title8" class="accordion-label">Comment faire pour voir les résultats d'une consultation traitée ?</label>
                    <div class="accordion-content">
                        <p> Après l'authentification, aller sur l'onglet &laquo; Resultats &raquo; pour voir vos consultations qui ont été traitées. Cliquer sur le bouton "Télécharger" pour avoir les données de traitement de votre consultation</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'

export default {
    components: {NavBar},
}
</script>
