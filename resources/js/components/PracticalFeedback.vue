<template>
    <div v-if="feedbackToggle" class="feedback-block">
        <div class="feedback-row">
            <div class="feedback-title">Оцените материалы практической работы!</div>
            <div class="feedback-column">
                <div class="feedback-row feedback-row_margin">
                    <label class="feedback-label" :key="index" v-for="(item, index) in feedbacks">
                        <input type="radio" class="feedback-input"
                               v-model="feedbackValue"
                               :value="item.feedback">
                        <img :src="'/images/emoticons/' + item.src"  alt="emoticons" class="feedback-icon"/>
                    </label>
                </div>
                <button @click="feedbackToggle == !feedbackToggle" type="submit"
                        class="btn border-orange btn-warning background-orange_hover background-orange text-white">Отравить
                </button>
            </div>
        </div>
        <input type="hidden" name="body" :value="feedbackValue">
    </div>
</template>

<script>
export default {
    name: "PracticalFeedback",
    data() {
        return {
            feedbackValue: '',
            feedbackToggle: true,
            feedbacks: [
                {
                    title: 'Standart cleaning',
                    feedback: '1',
                    src: 'terribly.png',
                },
                {
                    title: 'Standart cleaning',
                    feedback: '2',
                    src: 'badly.png'
                },
                {
                    title: 'Standart cleaning',
                    feedback: '3',
                    src: 'normally.png'
                },
                {
                    title: 'Standart cleaning',
                    feedback: '4',
                    src: 'fine.png'
                },
                {
                    title: 'Standart cleaning',
                    feedback: '5',
                    src: 'perfectly.svg'
                },
            ]
        }
    },
}
</script>

<style lang="scss">
.feedback {
    &-block {
        background: #fabe4b21;
        border: 1px solid #fabe4b;
        padding: 20px;
        border-radius: 20px;
        margin: 35px 0;
    }
    &-column {
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        margin-left: 2rem;
    }
    &-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        &_margin {
            margin-bottom: 1rem;
            flex-direction: row-reverse;
        }
    }

    &-title {
        font-weight: bold;
        display: block;
        font-size: 1.5rem;
        text-align: center;
    }

    &-icon {
        width: 100%;
        height: 100%;
        object-fit: cover;
        opacity: 0.8;
    }

    &-input {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        &:checked + .feedback-icon {
            opacity: 1;
        }
    }

    &-label {
        width: 3rem;
        height: 3rem;
        position: relative;
        margin: 0 5px;
    }
}
</style>
