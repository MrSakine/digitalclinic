<template>
    <Head />
    <div class="home_nav_container">
        <NavBar :agendaActive="true" :NbNotifications="0" />
        <div class="home_container_right">
            <button class="btn btn-secondary btn-lg mb-3 agendaTooltip" type="button">Aide ?</button>
            <table class="table caption-top table-bordered table-hover">
                <caption>Agenda</caption>
                <thead>
                    <th>#</th>
                    <th>Jour</th>
                    <th>Disponibilité</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <agenda-dispo :data="data" @added="getAgendas" @edited="getAgendas" @deleted="getAgendas" />
                </tbody>
            </table>
        </div>
    </div>
    <div id="agendaInfo" style="display:none;">
        <h4>Informations</h4>
        <span>
            Utilisez cette partie du système pour créer vos horaires de disponibilité
        </span>
    </div>
</template>

<script>
import NavBar from '../components/NavBar.vue'
import Ordonnance from '../components/Ordonnance.vue'
import Head from '../components/Head.vue'
import agendaDispo from '../components/agendaDispo.vue'
import jbox from 'jbox'
import axios from 'axios'

export default {
  components: { NavBar, Ordonnance, Head, agendaDispo },
  mounted() {
    new jbox('Tooltip', {
        attach: '.agendaTooltip',
        trigger: 'mouseenter',
        content: $('#agendaInfo'),
        position: {
            x: 'right',
            y: 'bottom'
        },
        outside: 'x',
        theme: 'TooltipBorder'
    })
    this.getAgendas()
  },
  data() {
      return {
          data: [
              { jour: 'Lundi', disponibilite: 'Indéfini', state: false},
              { jour: 'Mardi', disponibilite: 'Indéfini', state: false},
              { jour: 'Mercredi', disponibilite: 'Indéfini', state: false},
              { jour: 'Jeudi', disponibilite: 'Indéfini', state: false},
              { jour: 'Vendredi', disponibilite: 'Indéfini', state: false},
              { jour: 'Samedi', disponibilite: 'Indéfini', state: false},
              { jour: 'Dimanche', disponibilite: 'Indéfini', state: false},
          ],
          tmp: []
      }
  },
  methods: {
      getAgendas: function() {
          axios.get('/api/getmedagenda')
          .then(res => {
              if (res.data.details.length > 0) {
                let els = []
                this.tmp = res.data.details
                for(const el of this.data) {
                    for(const sub_el of this.tmp) {
                        if (sub_el.jour === el.jour) {
                            els.push({
                                jour: el.jour,
                                disponibilite: sub_el.disponibilite,
                                state: true
                            })
                        }
                    }
                }
                for(const el of this.data) {
                    if (!(els.filter(value => value.jour === el.jour).length > 0)) {
                        els.push({
                            jour: el.jour,
                            disponibilite: 'Indéfini',
                            state: false
                        })
                    }
                }
                this.data = els
              }else{
                  this.data = [
                    { jour: 'Lundi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Mardi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Mercredi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Jeudi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Vendredi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Samedi', disponibilite: 'Indéfini', state: false},
                    { jour: 'Dimanche', disponibilite: 'Indéfini', state: false},
                ]
              }
          })
          .catch(err => console.log(err))
      }
  },
}
</script>
