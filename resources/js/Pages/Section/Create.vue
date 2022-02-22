<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
import { reactive } from 'vue'
import { Inertia } from '@inertiajs/inertia'
const form = reactive({
    title: null,
    description: null,
})

function submit() {
    Inertia.post(route('section.store'), form)
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
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Новая секция</h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <form
                        @submit.prevent="submit"
                        class="w-full flex items-center flex-col p-4 py-6"
                    >
                        <div class="flex items-center border-b border-primary-700 py-1 my-2">
                            <input
                                v-model="form.title"
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none focus:shadow-none ring-0 focus:ring-0"
                                type="text"
                                placeholder="Наименование"
                            />
                        </div>
                        <div class="flex items-center border-b border-primary-700 py-1 my-2">
                            <input
                                v-model="form.description"
                                class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none focus:shadow-none ring-0 focus:ring-0"
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
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
