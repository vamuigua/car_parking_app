import { createApp } from 'vue'
import { createPinia } from 'pinia'
import axios from '@/lib/axios'
import router from './router'

import App from './App.vue'
import ValidationError from '@/components/ValidationError.vue'
import IconSpinner from '@/components/IconSpinner.vue'

import './assets/main.css'

window.axios = axios

const app = createApp(App)

app.use(createPinia())
app.use(router)

app.component('ValidationError', ValidationError)
app.component('IconSpinner', IconSpinner)

app.mount('#app')
