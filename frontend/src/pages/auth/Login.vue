<template>
    <body>
    <section class="h-screen">
      <div class="px-6 h-full text-gray-800 flex justify-center">
        <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
            <div class="relative overflow-hidden rounded-2xl bg-slate-900 shadow-xl ring-1 ring-slate-200/70 grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0">
                <img
                    src="https://images.unsplash.com/photo-1555215695-3004980ad54e?q=80&w=1170&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                    class="block w-full object-cover"
                    alt="Современный автомобиль в городской среде"
                />
                <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-slate-900/45 via-slate-900/10 to-transparent"></div>
            </div>
            <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
              <h2 class="pb-6 text-3xl font-bold">Авторизация</h2>
              <form @submit.prevent="onSubmit">
                  <div class="mb-6">
                      <input
                          type="email"
                          class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                          id="email"
                          name="email"
                          placeholder="Email"
                          autocomplete="email"
                          inputmode="email"
                          v-model="form.email"
                      />
                  </div>    
                  <div class="mb-6">
                      <input
                          type="password"
                          class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                          id="password"
                          name="password"
                          placeholder="Пароль"
                          v-model="form.password"
                      />
                  </div>    
                  <div class="flex justify-between items-center mb-6">
                        <router-link to="/forgot" class="text-gray-800 hover:text-blue-600">Забыли пароль?</router-link>
                  </div>    
                  <div class="text-center lg:text-left">
                      <button 
                            type="submit" 
                            class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                            Войти
                      </button>
                      <p v-if="errorMessage" class="text-sm text-red-600 mt-3">{{ errorMessage }}</p>
                      <p class="text-sm font-semibold mt-2 pt-1 mb-0">
                            Нет аккаунта?
                            <router-link to="/register" class="text-red-600 hover:text-red-700 transition duration-200 ease-in-out">Зарегистрироваться</router-link>
                      </p>
                  </div>
              </form>
            </div>
        </div>
      </div>
    </section>
  </body>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { api, setAuthToken } from '../../lib/api'

const router = useRouter()
const errorMessage = ref('')
const form = reactive({
  email: '',
  password: '',
})

async function onSubmit() {
  errorMessage.value = ''
  try {
    const response = await api.post('/auth/login', form)
    const token = response?.data?.data?.token
    if (!token) throw new Error('Token not received')
    setAuthToken(token)
    await router.push('/app')
  } catch (error) {
    errorMessage.value = error?.response?.data?.message || 'Не удалось войти. Проверьте email и пароль.'
  }
}
</script>