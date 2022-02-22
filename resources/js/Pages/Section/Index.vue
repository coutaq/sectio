<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Секции</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3>Ваши секции:</h3>
                    </div>
                    <div class="p-6 overflow-hidden flex" v-dragscroll.x>
                        <div
                            v-for="section in sections.data"
                            class="border w-[500px] shrink-0 mx-3 border-gray-200 bg-white rounded-lg shadow"
                        >
                            <div
                                class="w-full p-0 m-0 border-b-4 border-primary-700 flex justify-between items-end"
                            >
                                <h3 class="p-3 font-bold text-xl">{{ section.title }}</h3>
                                <div class="flex items-center px-2">
                                    <Link class="py-3 px-1 text-xl">
                                        <div
                                            class="aspect-square w-10 bg-white border-2 border-primary-200 rounded p-2 flex justify-center shadow"
                                        >
                                            <i class="far fa-edit text-primary-900"></i>
                                        </div>
                                    </Link>

                                    <Link class="py-3 px-1 text-xl">
                                        <div
                                            class="aspect-square w-10 bg-white border-2 border-primary-200 rounded p-2 flex justify-center shadow"
                                        >
                                            <i class="far fa-trash-alt text-primary-900"></i>
                                        </div>
                                    </Link>
                                </div>
                            </div>
                            <div class="w-full flex flex-col">
                                <div
                                    v-for="activity in section.sectionActivities.data"
                                    class="border shrink-0 m-3 p-1 border-gray-200 bg-white rounded shadow-lg"
                                >
                                    <p>{{ activity.title }}</p>
                                </div>
                                <div
                                    class="border shrink-0 m-3 p-1 border-gray-200 bg-white rounded shadow-lg"
                                >
                                    <Link
                                        class="w-full flex justify-center"
                                        :href="route('section-activity.create')"
                                    >
                                        <svg
                                            width="40"
                                            height="40"
                                            viewBox="0 0 100 100"
                                            fill="none"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <g clip-path="url(#clip0_6_6)">
                                                <path
                                                    d="M20.7162 54.928C19.8522 54.928 19.1322 54.64 18.5562 54.064C17.9802 53.488 17.6922 52.768 17.6922 51.904C17.6922 51.136 17.9802 50.512 18.5562 50.032C19.1322 49.456 19.8522 49.168 20.7162 49.168H80.3322C81.1962 49.168 81.9162 49.456 82.4922 50.032C83.0682 50.608 83.3562 51.328 83.3562 52.192C83.3562 52.864 83.0682 53.488 82.4922 54.064C81.9162 54.64 81.1962 54.928 80.3322 54.928H20.7162ZM50.5242 87.04C49.6602 87.04 48.9402 86.752 48.3642 86.176C47.7882 85.6 47.5002 84.88 47.5002 84.016V21.376C47.5002 20.416 47.7882 19.648 48.3642 19.072C48.9402 18.496 49.6602 18.208 50.5242 18.208C51.4842 18.208 52.2042 18.496 52.6842 19.072C53.2602 19.648 53.5482 20.368 53.5482 21.232V83.872C53.5482 84.832 53.2602 85.6 52.6842 86.176C52.1082 86.752 51.3882 87.04 50.5242 87.04Z"
                                                    fill="#192657"
                                                />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_6_6">
                                                    <rect width="100" height="100" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </Link>
                                </div>
                            </div>
                        </div>
                        <Link
                            :href="route('section.create')"
                            class="border w-[500px] shrink-0 mx-3 border-gray-200 bg-white rounded-lg shadow flex justify-center"
                        >
                            <svg
                                width="80"
                                height="80"
                                viewBox="0 0 100 100"
                                fill="none"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <g clip-path="url(#clip0_6_6)">
                                    <path
                                        d="M20.7162 54.928C19.8522 54.928 19.1322 54.64 18.5562 54.064C17.9802 53.488 17.6922 52.768 17.6922 51.904C17.6922 51.136 17.9802 50.512 18.5562 50.032C19.1322 49.456 19.8522 49.168 20.7162 49.168H80.3322C81.1962 49.168 81.9162 49.456 82.4922 50.032C83.0682 50.608 83.3562 51.328 83.3562 52.192C83.3562 52.864 83.0682 53.488 82.4922 54.064C81.9162 54.64 81.1962 54.928 80.3322 54.928H20.7162ZM50.5242 87.04C49.6602 87.04 48.9402 86.752 48.3642 86.176C47.7882 85.6 47.5002 84.88 47.5002 84.016V21.376C47.5002 20.416 47.7882 19.648 48.3642 19.072C48.9402 18.496 49.6602 18.208 50.5242 18.208C51.4842 18.208 52.2042 18.496 52.6842 19.072C53.2602 19.648 53.5482 20.368 53.5482 21.232V83.872C53.5482 84.832 53.2602 85.6 52.6842 86.176C52.1082 86.752 51.3882 87.04 50.5242 87.04Z"
                                        fill="#192657"
                                    />
                                </g>
                                <defs>
                                    <clipPath id="clip0_6_6">
                                        <rect width="100" height="100" fill="white" />
                                    </clipPath>
                                </defs>
                            </svg>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
export default {
    props: ['sections'],
    mounted() {
        console.log(this.sections.data[0])
    }
}
</script>