<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive, ref, watchEffect } from 'vue'
import { Inertia } from '@inertiajs/inertia'
const props = defineProps(['section', 'availible_admins', 'availible_pupils'])
const section = reactive(props.section.data)

const tempAdmins = reactive({ added: [], list: [], query: '' })
const tempPupils = reactive({ added: [], list: [], query: '' })
console.log(props.availible_pupils)
function submit() {
    Inertia.put(route('section.update', section), section)
}
let modal = reactive(
    {
        error: false,
        admin: false,
        pupil: false
    });
function removeAdmin(admin) {
    if (section.admins.data.length > 1) {
        Inertia.put(route('section/remove-admin', section.id), { 'user_id': admin.id });
        section.admins.data.pop(admin)
    } else {
        modal.error = true
    }
}
function filterAdmins() {
    tempAdmins.list = props.availible_admins.data.filter(a => {
        return a.name.toLowerCase().startsWith(tempAdmins.query.toLowerCase()) && tempAdmins.query;
    }).slice(0, 3);
}
function addAdmin(admin) {
    tempAdmins.list.pop(admin)
    tempAdmins.added.push(admin)
}
function addAdmins() {
    console.log(tempAdmins.added)
    if (tempAdmins.added.length > 0) {
        Inertia.put(route('section/add-admins', section.id), { 'admins': tempAdmins.added });
        section.admins.data = section.admins.data.concat(tempAdmins.added)
    }
    modal.admin = false
}



function removePupil(pupil) {
    Inertia.put(route('section/remove-pupil', section.id), { 'user_id': pupil.id });
    section.pupils.data.pop(pupil)
}
function filterPupils() {
    tempPupils.list = props.availible_pupils.data.filter(a => {
        return a.name.toLowerCase().startsWith(tempPupils.query.toLowerCase()) && tempPupils.query;
    }).slice(0, 3);
}
function addPupil(pupil) {
    tempPupils.list.pop(pupil)
    tempPupils.added.push(pupil)
}
function addPupils() {
    // console.log(tempPupils.added)
    if (tempPupils.added.length > 0) {
        Inertia.put(route('section/add-pupils', section.id), { 'pupils': tempPupils.added });
        section.pupils.data = section.pupils.data.concat(tempPupils.added)
    }
    modal.pupil = false
}
</script>

        <template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <div class="flex items-center">
                <Link :href="route('section.index')">
                    <svg
                        width="26"
                        height="26"
                        viewBox="0 0 32 32"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <g clip-path="url(#clip0_13_2)">
                            <path
                                d="M21.417 23.152C21.289 23.152 21.1503 23.12 21.001 23.056C20.8517 22.992 20.713 22.928 20.585 22.864L9.353 16.464C9.097 16.3147 8.91567 16.1547 8.809 15.984C8.72367 15.792 8.681 15.5787 8.681 15.344C8.681 15.088 8.745 14.8747 8.873 14.704C9.02233 14.512 9.21433 14.352 9.449 14.224L20.489 7.952C20.617 7.888 20.745 7.83467 20.873 7.792C21.001 7.728 21.1183 7.696 21.225 7.696C21.5023 7.67467 21.737 7.76 21.929 7.952C22.121 8.144 22.217 8.368 22.217 8.624C22.217 8.83733 22.1637 9.008 22.057 9.136C21.9717 9.264 21.833 9.38133 21.641 9.488L10.377 15.824L10.313 14.928L21.513 21.264C21.8117 21.4133 22.0143 21.5627 22.121 21.712C22.2277 21.84 22.281 22.0107 22.281 22.224C22.281 22.4587 22.185 22.672 21.993 22.864C21.8223 23.056 21.6303 23.152 21.417 23.152Z"
                                fill="#192657"
                            />
                        </g>
                        <defs>
                            <clipPath id="clip0_13_2">
                                <rect width="32" height="32" fill="white" />
                            </clipPath>
                        </defs>
                    </svg>
                </Link>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Редактировании секции
                    <b>{{ section.title }}</b>
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <h2 class="text-2xl text-bold text-center p-3 pt-6">Информация о секции</h2>
                    <form
                        @submit.prevent="submit"
                        class="w-full flex items-center flex-col p-4 py-6"
                    >
                        <div class="flex items-center border-b border-primary-700 py-1 my-2">
                            <input
                                v-model="section.title"
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none focus:shadow-none ring-0 focus:ring-0"
                                type="text"
                                placeholder="Наименование"
                            />
                        </div>
                        <div class="flex items-center border-b border-primary-700 py-1 my-2">
                            <textarea
                                v-model="section.description"
                                class="appearance-none bg-transparent border-none w-full resize-none h-40 text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none focus:shadow-none ring-0 focus:ring-0"
                                type="text"
                                placeholder="Описание"
                            />
                        </div>
                        <div class="px-2 py-4 my-2">
                            <button
                                class="bg-primary-700 text-white p-2 rounded"
                                type="submit"
                            >Сохранить</button>
                        </div>
                    </form>

                    <h2 class="text-2xl text-bold text-center p-3">Администраторы секции</h2>
                    <div class="flex my-6 mx-16 border-2 rounded-lg relative overflow-clip">
                        <div
                            class="flex items-center justify-center bg-white text-xl m-0 bg-opacity-[0.99] font-light text-gray-500 absolute right-0 top-0 w-20 h-full shadow-lg"
                        >
                            <div @click="modal.admin = true">
                                <i
                                    class="fas fa-plus hover:rotate-90 hover:scale-150 ease-in-out duration-500 text-gray-700"
                                ></i>
                            </div>
                        </div>
                        <div class="flex overflow-x-hidden p-6" v-dragscroll.x>
                            <div
                                class="rounded-full select-none m-2 shrink-0 outline-2 outline outline-purple-300 bg-purple-200 p-2 px-4 text-gray-800 flex items-center"
                                v-for="admin in section.admins.data"
                            >
                                {{ admin.name }}
                                <div class="flex items-center ml-2" @click="removeAdmin(admin)">
                                    <i
                                        class="fas fa-times hover:rotate-90 hover:scale-110 ease-in-out duration-500 text-gray-700"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h2 class="text-2xl text-bold text-center p-3">Участники секции</h2>
                    <div class="flex my-6 mx-16 border-2 rounded-lg relative overflow-clip">
                        <div
                            class="flex items-center justify-center bg-white text-xl m-0 bg-opacity-[0.99] font-light text-gray-500 absolute right-0 top-0 w-20 h-full shadow-lg"
                        >
                            <div @click="modal.pupil = true">
                                <i
                                    class="fas fa-plus hover:rotate-90 hover:scale-150 ease-in-out duration-500 text-gray-700"
                                ></i>
                            </div>
                        </div>
                        <div class="flex overflow-x-hidden p-6" v-dragscroll.x>
                            <div
                                class="rounded-full select-none m-2 shrink-0 outline-2 outline outline-emerald-300 bg-emerald-200 p-2 px-4 text-gray-800 flex items-center"
                                v-for="pupil in section.pupils.data"
                            >
                                {{ pupil.name }}
                                <div class="flex items-center ml-2" @click="removePupil(pupil)">
                                    <i
                                        class="fas fa-times hover:rotate-90 hover:scale-110 ease-in-out duration-500 text-gray-700"
                                    ></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="modal.error"
            class="fixed z-10 inset-0 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"
                ></div>
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                >&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10"
                            >
                                <svg
                                    class="h-6 w-6 text-red-600"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"
                                    />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                    id="modal-title"
                                >Внимание!</h3>
                                <div class="mt-2">
                                    <p
                                        class="text-sm text-gray-500"
                                    >Невозможно удалить последнего администратора, иначе можно потерять доступ к секции.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            @click="modal.error = false"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >ОК</button>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="modal.admin"
            class="fixed z-10 inset-0 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"
                ></div>
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                >&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10"
                            >
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                    id="modal-title"
                                >Добавление администраторов</h3>
                                <div class="mt-2 flex flex-wrap justify-start">
                                    <div
                                        class="rounded-full select-none m-2 shrink-0 outline-2 outline outline-purple-300 bg-purple-200 p-2 px-4 text-gray-800 flex items-center"
                                        v-for="admin in tempAdmins.added"
                                    >
                                        {{ admin.name }}
                                        <div
                                            class="flex items-center ml-2"
                                            @click="tempAdmins.added.pop(admin)"
                                        >
                                            <i
                                                class="fas fa-times hover:rotate-90 hover:scale-110 ease-in-out duration-500 text-gray-700"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mr-6 my-2">
                                    <input
                                        v-model="tempAdmins.query"
                                        @keypress="filterAdmins"
                                        type="search"
                                        class="bg-purple-white shadow rounded border-0 p-3"
                                        placeholder="Поиск по имени..."
                                    />
                                    <div class="absolute top-12 shadow-md">
                                        <div
                                            @click="addAdmin(opt)"
                                            class="outline outline-1 outline-neutral-100 hover:bg-gray-200 hover:outline-gray-400 bg-white w-[210px] m-0 h-12 p-4 flex justify-between items-center transition-all duration-300"
                                            v-for="opt in tempAdmins.list"
                                        >
                                            <span class="h-full flex items-center">{{ opt.name }}</span>
                                            <div>
                                                <i class="fas fa-plus text-primary-500"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            @click="addAdmins()"
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >Сохранить</button>
                        <button
                            @click="modal.admin = false"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >Отменить</button>
                    </div>
                </div>
            </div>
        </div>
        <div
            v-if="modal.pupil"
            class="fixed z-10 inset-0 overflow-y-auto"
            aria-labelledby="modal-title"
            role="dialog"
            aria-modal="true"
        >
            <div
                class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0"
            >
                <div
                    class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                    aria-hidden="true"
                ></div>
                <span
                    class="hidden sm:inline-block sm:align-middle sm:h-screen"
                    aria-hidden="true"
                >&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-visible shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-primary-100 sm:mx-0 sm:h-10 sm:w-10"
                            >
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                    id="modal-title"
                                >Добавление участников</h3>
                                <div class="mt-2 flex flex-wrap justify-start">
                                    <div
                                        class="rounded-full select-none m-2 shrink-0 outline-2 outline outline-emerald-300 bg-emerald-200 p-2 px-4 text-gray-800 flex items-center"
                                        v-for="pupil in tempPupils.added"
                                    >
                                        {{ pupil.name }}
                                        <div
                                            class="flex items-center ml-2"
                                            @click="tempPupils.added.pop(pupil)"
                                        >
                                            <i
                                                class="fas fa-times hover:rotate-90 hover:scale-110 ease-in-out duration-500 text-gray-700"
                                            ></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative mr-6 my-2">
                                    <input
                                        v-model="tempPupils.query"
                                        @keypress="filterPupils"
                                        type="search"
                                        class="bg-purple-white shadow rounded border-0 p-3"
                                        placeholder="Поиск по имени..."
                                    />
                                    <div class="absolute top-12 shadow-md">
                                        <div
                                            @click="addPupil(opt)"
                                            class="outline outline-1 outline-neutral-100 hover:bg-gray-200 hover:outline-gray-400 bg-white w-[210px] m-0 h-12 p-4 flex justify-between items-center transition-all duration-300"
                                            v-for="opt in tempPupils.list"
                                        >
                                            <span class="h-full flex items-center">{{ opt.name }}</span>
                                            <div>
                                                <i class="fas fa-plus text-primary-500"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button
                            @click="addPupils()"
                            type="button"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto sm:text-sm"
                        >Сохранить</button>
                        <button
                            @click="modal.admin = false"
                            type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >Отменить</button>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>