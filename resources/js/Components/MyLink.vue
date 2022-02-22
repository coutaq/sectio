<script setup>
import { ref } from 'vue';
import BreezeNavLink from '@/Components/NavLink.vue';

</script>

<template>
    <div class="space-x-8 sm:-my-px sm:ml-10 flex">
        <BreezeNavLink :href="route(link)" :active="checkActive(route().current())">{{ title }}</BreezeNavLink>
    </div>
</template>
<script>
export default {
    props: {
        link: String,
        title: String
    },
    methods: {
        checkActive(current) {
            return current.split('.')[0] == this.link.split('.')[0]
        }
    }
}
</script>