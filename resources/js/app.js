require('./bootstrap')
import { createApp } from 'vue'
import routes from './router'
import jBox from 'jbox'
import 'animate.css'
import Cleave from 'vue-cleave-component'
import App from './App.vue'
import Toast from "vue-toastification"
import "vue-toastification/dist/index.css"
import 'jbox/dist/jBox.all.css'
import AOS from 'aos';
import 'aos/dist/aos.css';
AOS.init();

const app = createApp(App)
app.use(routes)
app.use(Cleave)
app.use(Toast, { showCloseButtonOnHover: true, transition: "Vue-Toastification__bounce" })
app.use(jBox)
app.mount("#app")
