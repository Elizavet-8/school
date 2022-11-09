<template>
    <div class="form-group">
        <label>1. Отметьте статус практической</label>
        <div style="margin-left: 1.5rem;" class="form-group" :key="index" v-for="(item, index) in corrects">
            <input class="form-check-input" type="radio"
                   v-model="correctValue"
                   :value="item.correct">
            <label class="form-check-label">
                {{ item.correct }}
            </label>
        </div>
        <input type="hidden" name="correct" :value="correctValue">
    </div>
</template>

<script>
export default {
    name: "PracticalCorrect",
    data() {
        return {
            correctValue: '',
            corrects: [
                {
                    correct: 'принята',
                },
                {
                    correct: 'отправлена на доработку',
                },
                {
                    correct: 'отклонена',
                },
            ]
        }
    },
}
</script>

<style scoped>

</style>
