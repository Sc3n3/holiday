import '@mdi/font/css/materialdesignicons.css'

import 'vuetify/styles'
import { createVuetify } from 'vuetify'

export default defineNuxtPlugin((app) => {
    const vuetify = createVuetify({
        ssr: true,
        theme: {
            themes: {
                light: {
                    colors: {
                        background: "#fbfbfb"
                    }
                }
            }
        }
    })
    app.vueApp.use(vuetify)
})