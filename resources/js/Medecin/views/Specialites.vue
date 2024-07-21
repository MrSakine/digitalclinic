<template>
    <Head />
    <div class="home_nav_container">
        <NavBar :specialiteActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 speTooltip mx-2" type="button">Aide ?</button>
            <div class="container">
                <span class="text-muted mb-5">Liste des spécialités</span>
                <spe-list
                    v-for="(d, index) in data" :key="index"
                    :index="index + 1"
                    :content="d"
                />
            </div>
        </div>
    </div>
    <div id="speInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Utilisez cette partie du système pour voir vos différentes spécialités
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Ordonnance from '../components/Ordonnance.vue'
import Head from '../components/Head.vue'
import jbox from 'jbox'
import speList from '../components/speList.vue'

export default {
  components: { NavBar, Ordonnance, Head, speList },
  mounted() {
    new jbox('Tooltip', {
        attach: '.speTooltip',
        trigger: 'mouseenter',
        content: $('#speInfo'),
        position: {
            x: 'right',
            y: 'bottom'
        },
        outside: 'x',
        theme: 'TooltipBorder'
    })
    this.getSpe()
  },
  methods: {
      getSpe: function() {
          axios.get('/api/getspe')
          .then(res => {
              this.data = res.data.spe
          })
          .catch(err => console.log(err))
      }
  },
  data() {
      return {
          data: []
      }
  },
}
</script>
