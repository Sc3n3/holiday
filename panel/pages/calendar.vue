<template>
  <v-card v-for="holiday in holidays" class="my-5 pa-5">
    <v-row>
      <v-col cols="10">
        <span class="text-caption text-grey-lighten-1">{{ new Date(holiday.start_date).toDateString() }}</span>
        <h3>{{ holiday.name }}</h3>
      </v-col>
      <v-col class="text-right flex justify-center align-content-center">
        <v-btn v-on:click="setForm(holiday)">
          Düzenle

          <v-dialog activator="parent" v-model="modal" width="auto">
            <v-card>
              <v-btn class="close-popup"
                     icon="mdi-close-thick"
                     color="black"
                     size="x-small"
                     elevation="0" @click="modal = false" style="position:absolute;right:5px;top:5px"/>
              <v-form v-on:submit="update">
                <v-card-title class="text-h6">
                  Düzenle
                </v-card-title>
                <v-card-text>
                  <v-row>
                    <v-col cols="6">
                      <v-text-field type="date" v-model="form_date" label="Tarih" />
                    </v-col>
                    <v-col cols="6">
                      <v-text-field type="text" v-model="form_title" label="Başlık" />
                    </v-col>
                    <v-col cols="12">
                      <v-textarea
                          v-model="form_note"
                          clearable
                          auto-grow
                          variant="filled"
                          clear-icon="mdi-close-circle"
                          label="Not Ekle"
                      ></v-textarea>
                    </v-col>
                  </v-row>
                </v-card-text>
                <v-card-actions>
                  <v-row>
                    <v-col cols="6" class="text-left">
                      <v-btn @click="modal = false">İptal</v-btn>
                    </v-col>
                    <v-col cols="6" class="text-right">
                      <v-btn class="bg-purple-accent-4 text-white" type="submit">Kaydet</v-btn>
                    </v-col>
                  </v-row>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>
        </v-btn>
      </v-col>
    </v-row>
  </v-card>
</template>

<script setup>
  const modal = ref(false);
  const form_id = ref(null);
  const form_date = ref(null);
  const form_title = ref(null);
  const form_note = ref(null);

  const [ holidays, setHolidays ] = useCustomState();

  function setForm(holiday){
    form_id.value = holiday.id;
    form_date.value = holiday.start_date.slice(0,10);
    form_title.value = holiday.name;
    form_note.value = holiday.note;

    console.log(holiday);
  }

  async function update(e){
    e.preventDefault();

    if ([form_id.value, form_title.value, form_date.value].includes(null)) {
      return false;
    }

    try {
      await $fetch(useRuntimeConfig().public.apiURL + '/holidays/'+ form_id.value, {
        method: 'put',
        body: {
          name: form_title.value,
          date: form_date.value,
          note: form_note.value
        }
      });

      getHolidays();
      modal.value = false;
    } catch (e) {
      alert('Error!');
    }
  }

  async function getHolidays() {
    const results = await $fetch(useRuntimeConfig().public.apiURL + '/holidays');
    setHolidays(results);
  }

  getHolidays();
</script>