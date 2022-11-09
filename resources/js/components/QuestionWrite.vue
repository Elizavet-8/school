<template>
    <div style="margin-bottom:50px">
        <div>{{ index }}. {{ question.content }}</div>
        <div class="form-check">
            <input class="form-check-input" type="text" v-model="text" />
        </div>
    </div>
</template>

<script>
export default {
    props: ["question", "index", "admin"],
    created() {
        let correct;

        correct = JSON.parse(this.question.correct);

        if (this.admin) {
            this.text = correct[0].result;
        }
        this.correct = correct[0].result;

        if (!this.admin) {
            this.$emit("answer", {
                answer: this.text == this.correct,
                question_index: this.question.id
            });
        } else {
            this.$emit("answer", {
                answer: this.text,
                question_index: this.index
            });
        }
    },
    data: function() {
        return {
            text: "",
            correct: ""
        };
    },
    watch: {
        text: {
            handler: function(newVal, oldVal) {
                if (!this.admin) {
                    this.$emit("answer", {
                        answer: this.text == this.correct,
                        question_index: this.question.id
                    });
                } else {
                    this.$emit("answer", {
                        answer: this.text,
                        question_index: this.index
                    });
                }
            },
            deep: true
        }
    },
    methods: {
        b64DecodeUnicode(str) {
            // Going backwards: from bytestream, to percent-encoding, to original string.
            return decodeURIComponent(
                atob(str)
                    .split("")
                    .map(function(c) {
                        return (
                            "%" +
                            ("00" + c.charCodeAt(0).toString(16)).slice(-2)
                        );
                    })
                    .join("")
            );
        },
        equalsIgnoreOrder(a, b) {
            if (a.length !== b.length) return false;
            const uniqueValues = new Set([...a, ...b]);
            for (const v of uniqueValues) {
                const aCount = a.filter(e => e === v).length;
                const bCount = b.filter(e => e === v).length;
                if (aCount !== bCount) return false;
            }
            return true;
        }
    }
};
</script>
