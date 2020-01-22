<template>
  <div class="container col-md-12">
    <div class="row justify-content-center">
      <div class="col-md-8 text-center mt-4">
        <a href="#" class="naa pull-right" data-toggle="modal" data-target="#create">
          Nuevo Evento
        </a>

      <!-- Modal de Vue -->
      <b-modal id="modal-2" title="BootstrapVue">
        <p class="my-4">Nombre del Evento</p>
        <p class="my-4">Fecha Inicio</p>
        <p class="my-4">Fecha Fin</p>
        <p class="my-4">Hora Inicio</p>
      </b-modal>

    </div>

      <div class="col-md-10">
        <FullCalendar
            @eventClick="showEvent"
            :plugins="calendarPlugins"
            :events="events"
            defaultView="dayGridMonth"
            locale="es"
            :eventColor="event_color"
        />
      </div>

    </div>

    <div class="modal fade" v-if="modal" id="create" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" @click = "closeModal" class="close" data-dismiss="modal">
                  <span>×</span>
              </button>
              <!-- <h4>Crear</h4> -->
          </div>
            <div class="modal-body">
              <div class="col-md-12">
                <form @submit.prevent>
                  <div class="form-group">
                    <label for="event_name">Nombre del Evento</label>
                    <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name">
                  </div>
                  <div class="form-group">
                    <label for="event_hora">Hora Inicio</label>
                    <input type="text" id="event_hora" class="form-control" v-model="newEvent.event_hora">
                  </div>
                  <div class="form-group d-none">
                    <label for="color">Color</label>
                    <input id="color" class="form-control" v-model="newEvent.color">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">Fecha Inicio</label>
                        <input
                          type="date"
                          id="start_date"
                          class="form-control"
                          v-model="newEvent.start_date"
                        >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date">Fecha Fin</label>
                        <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <div class="col-md-12" >
                <button class="btn btn-sm btn-primary" @click="addNewEvent">Guardar</button>
              </div>
            </div>
        </div>
      </div>
    </div>

  <!-- Modal para ver o actualizar -->

      <div class="modal fade" v-if="modal" id="create2" data-backdrop="static">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
              <button type="button" @click = "closeModal" class="close" data-dismiss="modal">
                  <span>×</span>
              </button>
              <!-- <h4>Crear</h4> -->
          </div>
            <div class="modal-body">
              <div class="col-md-12">
                <form @submit.prevent>
                  <div class="form-group">
                    <label for="event_name">Nombre del Evento</label>
                    <input type="text" id="event_name" class="form-control" v-model="newEvent.event_name">
                  </div>
                  <div class="form-group">
                    <label for="event_hora">Hora Inicio</label>
                    <input type="text" id="event_hora" class="form-control" v-model="newEvent.event_hora">
                  </div>
                  <div class="row">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="start_date">Fecha Inicio</label>
                        <input
                          type="date"
                          id="start_date"
                          class="form-control"
                          v-model="newEvent.start_date"
                        >
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="end_date">Fecha Fin</label>
                        <input type="date" id="end_date" class="form-control" v-model="newEvent.end_date">
                      </div>
                    </div>
                    <!-- v-for="(id, evento) in eventos" :key="evento.id   v-text="evento.id"  -->
                    <div class="col-md-6">
                      <p class="card-text text-secondary" ></p>
                      <!-- <h1>{{ evento.event_name }}</h1> -->
                    </div>

                    <div class="col-md-6">
                      <div class="form-group" style="display: none">
                        <label for="user_id">Área</label>
                        <input type="text" id="user_id" class="form-control"
                            v-model="newEvent.user_id"  disabled="">
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="user_id">Área</label>
                        <input type="text" id="user_id" class="form-control"
                            v-model="newEvent.user_name"  disabled="">
                      </div>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="modal-footer">
              <div class="col-md-12" v-if="addingMode">
                <button class="btn btn-sm btn-primary" @click="addNewEvent">Guardar</button>
              </div>
              <template v-else>
                <div class="col-md-12" v-if="other">
                  <button class="btn btn-sm btn-success" @click="updateEvent">Guardar</button>
                  <button class="btn btn-sm btn-danger" @click="deleteEvent">Eliminar</button>
                  <!-- <button class="btn btn-sm btn-secondary" @click="closeModal()">Cancelar</button> -->
                </div>
              </template>
            </div>
        </div>
      </div>
    </div>
	</div>
  <!-- @dateClick="handleDateClick" -->
</template>

<script>
import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from "@fullcalendar/interaction";

let user = document.head.querySelector('meta[name="user"]');


export default {
  components: {
    FullCalendar
  },
  data() {
    return {
      calendarPlugins: [dayGridPlugin, interactionPlugin],
      events: [],
      newEvent: {
        event_name: "",
        event_hora: "",
        start_date: "",
        end_date: "",
        user_id: "",
        user_name: "",
        color: ""
      },
      addingMode: true,
      indexToUpdate: "",
      modal: true,
      eventos: [],
      other: false,
      event_color: ""
    };
  },
  created() {
    this.getEvents();
    // console.log(this.user.name);
  },
  computed: {
    user() {
      return JSON.parse(user.content);
      // console.log(user.content);
    }
  },
  methods: {
    addNewEvent() {
    if (this.user.name == 'Informática') {

        this.newEvent.color = "#FF7F11";
        // var color = this.newEvent.color;
        // console.log(color);
      }else if (this.user.name == 'Procuraduria')
      {
        this.newEvent.color = "#CD5C5C";

    }else if (this.user.name == 'Tesoreria')
    {
        this.newEvent.color = "#FFB6C1";
    }

      axios.post("/calendars", {
          ...this.newEvent
        // event_name: this.newEvent.event_name,
        // event_hora: this.newEvent.event_hora,
        // start_date: this.newEvent.start_date,
        // end_date: this.newEvent.end_date,
        // user_id: this.newEvent.user_id,
        // user_name: this.newEvent.user_name,
        // color: this.newEvent.color

        })
        .then(data => {
          this.getEvents(); // update our list of events
          this.resetForm(); // clear newEvent properties (e.g. title, start_date and end_date)
        })
        .catch(err =>
          console.log("Unable to add new event!", err.response.data)
        );


    },
    showEvent(arg) {
      // console.log(arg);
      this.addingMode = false;
      this.modal = true;
      $('#create2').modal('show');
      // this.$bvModal.show('create');
      const { id, title, hora, start, end, user, user_name, color } = this.events.find(
        event => event.id === +arg.event.id
      );
      // this.indexToUpdate = calendar;
      this.indexToUpdate = id;
      this.newEvent = {
        event_name: title,
        event_hora: hora,
        start_date: start,
        end_date: end,
        user_id: user,
        user_name: user_name,
        color: color
      };

    if (this.newEvent.user_name == this.user.name) {
        this.other = true;
      }

    },
    updateEvent() {
      axios.put("/calendars/" + this.indexToUpdate, {
          ...this.newEvent
        })
        .then(resp => {
          console.log(this.newEvent.id);
          this.resetForm();
          this.getEvents();
          this.addingMode = !this.addingMode;
        })
        .catch(err =>
          console.log("Unable to update event!", err.response.data)
        );
    },
    deleteEvent() {
      axios.delete("/calendars/" + this.indexToUpdate)
        .then(resp => {
          this.resetForm();
          this.getEvents();
          this.addingMode = !this.addingMode;
        })
        .catch(err =>
          console.log("Unable to delete event!", err.response.data)
        );
    },
    getEvents() {
      axios.get("/calendars")
        .then(resp => (this.events = resp.data.data))
        .catch(err => console.log(err.response.data));
    },
    resetForm() {
      Object.keys(this.newEvent).forEach(key => {
        return (this.newEvent[key] = "");
      });
    },
    closeModal() {
        this.newEvent.event_name = ' ';
        this.newEvent.event_hora = ' ';
        this.newEvent.start_date = ' ';
        this.newEvent.end_date = ' ';
        this.newEvent.user_id = ' ';
        this.addingMode = true;
        this.other = false;
    },
    // eventColor(arg) {
    //   // console.log('fd');
    //   // this.$bvModal.show('modal-2')
    //   if (this.newEvent.user_name == 'Informática') {
    //     console.log('color rojo');
    //     // this.event_color = "#FF7F11";
    //   }else{
    //     console.log('khaaa');
    //   }
    // },

  },
  watch: {
    indexToUpdate() {
      return this.indexToUpdate;
    }
  }
};
</script>

<style lang='css'>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

</style>
<!--
// console.log(user.content);

// export default {
//   components: {
//     FullCalendar // make the <FullCalendar> tag available
//   },
//   data() {
//     return {
//       calendarPlugins: [ dayGridPlugin, interactionPlugin ],
//       events: "",
//     }
//   },
//   methods: {
//     handleDateClick() {
//       this.$bvModal.show('modal-1')
//     },

//     show() {
//       console.log('fd');
//       this.$bvModal.show('modal-2')
//     }
//   }
// }; -->





    <!-- Lo que hice -->

    <!-- <div>
      <b-button v-b-modal.modal-1>Launch demo modal</b-button>

      <b-modal id="modal-1" title="BootstrapVue">
        <p class="my-4">Hello from modal!</p>
      </b-modal>

      <b-modal id="modal-2" title="BootstrapVue">
        <p class="my-4">Nombre del Evento</p>
        <p class="my-4">Fecha Inicio</p>
        <p class="my-4">Fecha Fin</p>
        <p class="my-4">Hora Inicio</p>
      </b-modal>

    </div>

    <FullCalendar
      defaultView="dayGridMonth"
      :plugins="calendarPlugins"
      :events="events"
      @eventClick="showEvent"
      @dateClick="handleDateClick"
    />-->