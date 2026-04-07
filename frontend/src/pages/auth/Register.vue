<template>
  <body>
    <section class="h-screen">
      <div class="px-6 h-full text-gray-800 flex justify-center">
        <div class="flex xl:justify-center lg:justify-between justify-center items-center flex-wrap h-full g-6">
          <div class="grow-0 shrink-1 md:shrink-0 basis-auto xl:w-6/12 lg:w-6/12 md:w-9/12 mb-12 md:mb-0">
            <img
              src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
              class="w-full"
              alt="Sample image"
            />
          </div>

          <div class="xl:ml-20 xl:w-5/12 lg:w-5/12 md:w-8/12 mb-12 md:mb-0">
            <h2 class="pb-6 text-3xl font-bold">Регистрация</h2>

            <form>
              <div class="mb-6">
                <input
                  type="text"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="name"
                  name="name"
                  placeholder="Полное имя"
                  autocomplete="name"
                  inputmode="text"
                  @input="onNameInput"
                />
              </div>

              <div class="mb-6">
                <input
                  type="email"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="email"
                  name="email"
                  placeholder="Email"
                  autocomplete="email"
                  inputmode="email"
                />
              </div>

              <div class="mb-6">
                <input
                  type="tel"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="phone"
                  name="phone"
                  placeholder="+7 (___) ___-__-__"
                  autocomplete="tel"
                  inputmode="tel"
                  maxlength="18"
                  pattern="^\+7\s?\(\d{3}\)\s?\d{3}-\d{2}-\d{2}$"
                  @input="onPhoneInput"
                />
              </div>

              <div class="mb-6">
                <input
                  type="text"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="birthday"
                  name="birthday"
                  placeholder="ДД.ММ.ГГГГ"
                  inputmode="numeric"
                  maxlength="10"
                  pattern="^\d{2}\.\d{2}\.\d{4}$"
                  @input="onBirthdayInput"
                />
              </div>

              <div class="mb-6">
                <input
                  type="password"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="password"
                  name="password"
                  placeholder="Пароль"
                />
              </div>

              <div class="mb-6">
                <input
                  type="password"
                  class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                  id="passwordConfirm"
                  name="passwordConfirm"
                  placeholder="Подтверждение пароля"
                />
              </div>

              <div class="text-center lg:text-left">
                <button 
                  type="button" 
                  class="inline-block px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out">
                  Зарегистрироваться
                </button>

                <p class="text-sm font-semibold mt-2 pt-1 mb-0">
                  Уже есть аккаунт?
                  <router-link to="/login" class="text-red-600 hover:text-red-700 transition duration-200 ease-in-out">
                    Войти
                  </router-link>
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
function onNameInput(event) {
  const el = event.target
  const value = (el.value ?? '').toString()
  el.value = value.replace(/[^А-Яа-яЁё\s]/g, '').replace(/\s+/g, ' ')
}

function formatPhoneRU(rawValue) {
  const digitsOnly = (rawValue ?? '').toString().replace(/\D/g, '').slice(0, 11)

  let national = digitsOnly
  if (digitsOnly.length === 11 && (digitsOnly.startsWith('7') || digitsOnly.startsWith('8'))) {
    national = digitsOnly.slice(1)
  }
  if (national.length > 10) national = national.slice(-10)

  const d = national
  const p1 = d.slice(0, 3)
  const p2 = d.slice(3, 6)
  const p3 = d.slice(6, 8)
  const p4 = d.slice(8, 10)

  let out = ''
  if (d.length === 0) return ''

  out = '+7'
  if (p1.length > 0) {
    out += ` (${p1}`
    if (p1.length === 3) out += ')'
  }
  if (p2.length > 0) {
    out += ` ${p2}`
  }
  if (p3.length > 0) {
    out += p2.length >= 3 ? `-${p3}` : `-${p3}`
  }
  if (p4.length > 0) {
    out += p3.length >= 2 ? `-${p4}` : `-${p4}`
  }

  return out
}

function onPhoneInput(event) {
  const el = event.target
  el.value = formatPhoneRU(el.value)
}

function formatBirthdayRU(rawValue) {
  const digitsOnly = (rawValue ?? '').toString().replace(/\D/g, '').slice(0, 8)
  const dd = digitsOnly.slice(0, 2)
  const mm = digitsOnly.slice(2, 4)
  const yyyy = digitsOnly.slice(4, 8)

  if (digitsOnly.length <= 2) return dd
  if (digitsOnly.length <= 4) return `${dd}.${mm}`
  return `${dd}.${mm}.${yyyy}`
}

function onBirthdayInput(event) {
  const el = event.target
  el.value = formatBirthdayRU(el.value)
}

</script>