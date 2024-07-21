<template>
    <div class="p-3 mx-2">
        <div class="shadow-sm bg-light rounded d-flex p-3">
            <div class="flex-grow-1">
             <div class="nav_bar_logo d-flex">
            <img src="/storage/images/logo.svg" />
            <span class="fs-3 text-info mx-2">DIGITAL<br>CLINIC</span>
           </div>
            </div>
            <div class="dropdown mt-4">
                <a class="nav-link dropdown-toggle btn btn-secondary mx-3 text-black-50 font-weight-bold" id="navbarDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                style="cursor: pointer;text-color:#000;">Profil</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li>
                        <router-link :to="{name: 'medecin-accueil-compte'}" class="dropdown-item">Gérer mon compte</router-link>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <Logout />
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import Logout from './Logout.vue'
export default {
    components: {Logout}
}
</script>
