<template>
    <div class="form-group">
        <label>Изменить статут</label>
        <div style="margin-left: 1.5rem;" class="form-group" :key="index" v-for="(item, index) in statuses">
            <input class="form-check-input" type="radio"
                   v-model="statusValue"
                   :value="item.status">
            <label class="form-check-label">
                {{ item.label }}
            </label>
        </div>
        <input type="hidden" name="status" :value="statusValue">
    </div>
</template>

<script>
export default {
    name: "PracticalStatus",
    data() {
        return {
            statusValue: '0',
            statuses: [
                {
                    status: '0',
                    label: 'Личная практическая',
                },
                {
                    status: '1',
                    label: 'Коллективная',
                }
            ]
        }
    },
}
</script>

<style scoped>

</style>
