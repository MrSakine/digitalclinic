<template>
    <div id="navbar">
        <div id="navbar__left">
            <div class="navbar-logo">
                <a href="/">
                    <img src="/storage/images/logo.svg" alt="Logo">
                </a>
            </div>
            <div class="navbar-text">
                <a href="/">
                    <p>digital clinic</p>
                </a>
            </div>
        </div>
        <div id="navbar__right">
            <router-link :to="{name: 'login'}">
                <button class="navbar__right_button-login">Se connecter</button>
            </router-link>
            <router-link :to="{name: 'inscription'}">
                <button class="navbar__right_button-signup">S'inscrire</button>
            </router-link>
            <router-link :to="{name: 'faq'}">
                <button class="navbar__right_button-faq">FAQ</button>
            </router-link>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        loginActive: Boolean,
        inscriptionActive: Boolean,
        accueilActive: Boolean,
        faqActive: Boolean,
        tbpActive: Boolean
    }
}
</script>
