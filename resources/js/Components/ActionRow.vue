<template>
    <div class="custom-action-row">
        <p class="current-selection">{{ date }}</p>
        <button class="select-button" @click="$emit('selectDate')">Select Date</button>
    </div>
</template>

<script>
import { computed, defineComponent } from 'vue';

export default defineComponent({
    emits: ['selectDate', 'closePicker'],
    props: {
        selectText: { type: String, default: 'Select' },
        cancelText: { type: String, default: 'Cancel' },
        internalModelValue: { type: [Date, Array], default: null },
        range: { type: Boolean, default: false },
        previewFormat: {
            type: [String, Function],
            default: () => '',
        },
        monthPicker: { type: Boolean, default: false },
        timePicker: { type: Boolean, default: false },
    },
    setup(props) {
        const date = computed(() => {
            if (props.internalModelValue) {
                const date = props.internalModelValue.getDate();
                const month = props.internalModelValue.getMonth() + 1;
                const year = props.internalModelValue.getFullYear();
                const hours = props.internalModelValue.getHours();
                const minutes = props.internalModelValue.getMinutes();

                return `${month}/${date}/${year}, ${hours}:${minutes}`;
            }
            return '';
        });

        return {
            date,
        };
    },
});
</script>