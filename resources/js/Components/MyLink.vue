<script setup>
import { ref } from 'vue';
import BreezeNavLink from '@/Components/NavLink.vue';
const props = defineProps(['link', 'title'])
function checkActive(current) {
    return current.split('.')[0] == props.link.split('.')[0]
}
</script>

<template>
    <div class="space-x-8 sm:-my-px sm:ml-10 flex">
        <BreezeNavLink
            :href="route(props.link)"
            :active="checkActive(route().current())"
        >{{ props.title }}</BreezeNavLink>
    </div>
</template>