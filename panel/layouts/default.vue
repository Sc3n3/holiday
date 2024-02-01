<template>
    <v-app>
      <v-toolbar absolute border color="#FFF" class="app-header">
        <v-btn color="#000" nuxt to="/">Aktarım</v-btn>
        <v-btn color="#000" nuxt to="/calendar">Takvim</v-btn>
      </v-toolbar>
      <div class="app-container">
        <NuxtPage />
      </div>
    </v-app>
</template>

<style>
  .app-header > div {
    justify-content: center;
  }
  .app-container {
    margin-top: 65px;
  }
</style>