<template>
  <v-container>
    <v-card>
      <v-form v-on:submit="search">
        <v-row class="pa-4">
          <v-col cols="6">
            <v-select
                v-model="country"
                :items="countries"
                item-title="name[0].text"
                item-value="isoCode"
                :rules="[v => !!v || 'Country is required']"
                label="Country"
                required />
          </v-col>
          <v-col>
            <v-text-field
                v-model="year"
                :rules="[v => !!v || 'Year is required']"
                :counter="10"
                label="Year"
                required
                hide-details />
          </v-col>
          <v-col class="text-center">
            <v-btn type="submit" size="x-large" class="mt-1 bg-purple-accent-4">Getir</v-btn>
          </v-col>
        </v-row>
      </v-form>
    </v-card>

    <v-form v-on:submit="add">
      <v-card v-for="holiday in holidays" class="my-5 pa-5">
        <v-row>
          <v-col cols="11">
            <span class="text-caption text-grey-lighten-1">{{ new Date(holiday.startDate).toDateString() }}</span>
            <h3>{{ holiday.name[0].text }}</h3>
          </v-col>
          <v-col class="text-right flex justify-center align-content-center">
            <v-checkbox-btn
                color="purple-accent-4"
                v-model="selected"
                :value="JSON.stringify(holiday)" />
          </v-col>
        </v-row>
      </v-card>

      <div class="text-center">
        <v-btn v-if="selected.length" type="submit" size="x-large" class="bg-green-accent-4 text-white">İçeri Aktar</v-btn>
      </div>
    </v-form>

  </v-container>
</template>

<script setup>
  const country = ref(null);
  const year = ref(new Date().getFullYear());
  const selected = ref([]);

  const [ holidays, setHolidays ] = useCustomState();
  const [ countries, setCountries ] = useCustomState();
  const results = await $fetch(useRuntimeConfig().public.apiURL + '/countries');

  setCountries(results);

  async function search(e) {
    e.preventDefault();

    if (!country.value || !year.value) {
      return false;
    }

    const results = await $fetch(useRuntimeConfig().public.apiURL + '/holidays/search', {
      query: {
        country: country.value,
        year: year.value
      }
    });

    setHolidays(results);
  }

  async function add(e) {
    e.preventDefault();

    if (!selected.value.length) {
      return false;
    }

    try {
      const result = await $fetch(useRuntimeConfig().public.apiURL + '/holidays', {
        method: 'post',
        body: {
          country: country.value,
          dates: { ...selected.value.map(json => JSON.parse(json)) }
        }
      });

      navigateTo('/calendar');
    } catch (e) {
      alert('Error!');
    }

  }
</script>