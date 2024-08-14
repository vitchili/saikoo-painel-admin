<template>
  <vue-cal 
    style="height: 700px" 
    class="vuecal--blue-theme" 
    locale="pt-br"
    :time-from="7 * 60"
    :time-to="21 * 60"
    :time-step="60"
    :disable-views="['years', 'year']"
    :events="events"
    events-on-month-view="short"
    :editable-events="{ title: false, drag: true, resize: true, delete: false, create: false }"
    :on-event-click="onEventClick"
    @event-drop="onEventDrop"
    @event-duration-change="onEventResize">
    <template #event="{ event }">
        <EventContent :event="event" />
    </template>
</vue-cal>
</template>

<script>
import VueCal from 'vue-cal';
import 'vue-cal/dist/vuecal.css';
import EventContent from './EventContent.vue';
import { put } from "@/services/api.js";

export default {
  components: { VueCal, EventContent },
  data() {
    return {
      events: [],
    };
  },
  mounted() {
    this.lembretes.forEach((item) => {
        var tecnicos = item.tecnicos;
        var tecnicosStr = '- ';
        
        tecnicos.forEach((tecnico) => {
            var tecnicoStr = tecnico.name.length > 1 ? tecnico.name.trim().split(" "): tecnico.name;
            tecnicosStr += tecnicoStr[0] + " - " 
        });

        var lembrete = {
            id: item.id,
            start: item.data_hora_inicio,
            end: item.data_hora_fim,
            title: tecnicosStr,
            content: 'Lembrete',
            descricao: item.descricao,
            class: `health criador-${item.criador.id}`,
            backgroundColor: item.criador.color_hash,
            color: '#fff'
        };

        this.events.push(lembrete);
    });

    this.chamados.forEach((item) => {
        var tecnicos = item.tecnicos;
        var tecnicosStr = '- ';
        
        tecnicos.forEach((tecnico) => {
            var tecnicoStr = tecnico.name.length > 1 ? tecnico.name.trim().split(" "): tecnico.name;
            tecnicosStr += tecnicoStr[0] + " - " 
        });

        var chamado = {
            id: item.id,
            start: item.data_hora_inicial,
            end: item.data_hora_final,
            title: tecnicosStr,
            content: 'Chamado #' + item.id,
            descricao: item.descricao.replace(/(<([^>]+)>)/ig, ''),
            class: `health criador-${item.criador.id}`,
            backgroundColor: item.criador.color_hash,
            color: '#fff'
        };

        this.events.push(chamado);
    });
  },
  props: {
    lembretes: Array,
    chamados: Array,
  },
  methods: {
    onEventClick (event, e) {
        if (event.content == 'Lembrete'){
          window.location.href = `/admin/lembretes/${event.id}/edit`;
        }else{
          window.location.href = `/admin/chamados/${event.id}/edit`;
        }

        e.stopPropagation();
    },
    onEventDrop ({ event, originalEvent, external }) {
      var location = (window.location.href).split('/admin/atendimento');
      
      if (event.content == 'Lembrete'){
        put(`${location[0]}/lembretes/${event.id}`, event).then(
          (response) => {
            console.log(response);
          }
        );
      } else {
        put(`${location[0]}/chamados/${event.id}`, event).then(
          (response) => {
            console.log(response);
          }
        );
      }
      
    },
    onEventResize (event, oldDate, originalEvent) {
      var location = (window.location.href).split('/admin/atendimento');
      var objLembreteOuChamado = Object.entries(event)[0][1];

      if (objLembreteOuChamado.content == 'Lembrete'){
        put(`${location[0]}/lembretes/${objLembreteOuChamado.id}`, event).then(
          (response) => {
            console.log(response);
          }
        );
      } else {
        put(`${location[0]}/chamados/${objLembreteOuChamado.id}`, event).then(
          (response) => {
            console.log(response);
          }
        );
      }
    }
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

.vuecal__event-time, .vuecal__event-content {
    font-size: .7rem !important;
}

.vuecal__event-title{
    font-size: .7rem !important;
    font-weight: 600;
}

.vuecal__event {
    background-color: rgba(76, 172, 175, 0.35);
    cursor: pointer;
    border-radius: 5px;
    box-shadow: 1px 1px 1px rgba(0,0,0,.2);
    border: solid .5px #eaeaea;
}

.vuecal {height: 90vh;}

button {
    font-size: 1rem !important;
}

.vuecal__flex .vuecal__menu {
  background-color: #0F1A59;
}

.vuecal__title-bar {
  background-color: #16257E !important;
}

.vuecal__title-bar button {
  color: #fff !important;
}

.vuecal__title {
  color: #fff;
}
</style>
