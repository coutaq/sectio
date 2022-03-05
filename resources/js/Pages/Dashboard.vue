<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head } from '@inertiajs/inertia-vue3';
import { defineProps } from 'vue';

const props = defineProps(['sections'])

</script>
<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Главная</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-3xl mb-6">Ваши задачи на сегодня:</h3>
                        <div class="w-full grid grid-cols-3 gap-4">
                            <div
                                class="col-span-1 border-2 rounded-md p-3 shadow-md"
                                v-for="section in sections.data.filter(e => { return e.sectionActivities.data.length })"
                            >
                                <span class="text-bold text-2xl mb-4">
                                    {{ section.title }}
                                    <div
                                        class="outline outline-2 outline-emerald-500 p-3 rounded-sm my-4"
                                        v-for="act in section.sectionActivities.data"
                                    >
                                        <p class="w-full">{{ act.title }}</p>
                                        <p class="w-full">{{ act.time.substring(0, 5) }}</p>
                                    </div>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
