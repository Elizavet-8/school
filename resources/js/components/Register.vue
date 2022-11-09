<template>
    <form v-on:submit.prevent="register" class="register__form">
        <div
            class="register__group"
            v-for="(info, index) in users"
            :key="index + 'q'"
        >
            <input
                type="text"
                class="register__input"
                :placeholder="info.placeholder"
                v-model="info.value"
            />
        </div>
        <Myselect
            v-for="(select, index) in selects"
            :key="index + 'w'"
            :select="select"
            v-on:result="result"
        ></Myselect>
        <label class="check option">
            <input class="check__input" type="checkbox" />
            <span class="check__box"></span>
            Принимаю условия
            <a href="#"
                >соглашения <br />
                и политики конфиденциальности</a
            >
        </label>
        <button type="submit" class="register__btn btn-blue btn-custom">
            Записаться в школу
        </button>
        <div class="modal fade" id="modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Спасибо!
                        </h4>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>
                            Ваша заявка принята и будет рассмотрена
                            <br />администратором системы в течение 24 часов.
                        </p>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </form>
</template>
<script>
import Myselect from "./landing/Select.vue";

export default {
    components: {
        Myselect
    },

    created() {
        const program = new URL(location.href).searchParams.get("program");

        if (program !== null) {
            switch (program) {
                case "basic":
                    this.selects[1].value = "Базовый";
                    break;

                case "classic":
                    this.selects[1].value = "Классический";
                    break;

                case "premium":
                    this.selects[1].value = "Премиум";
                    break;

                default:
                    break;
            }
        }
    },

    data: () => ({
        disabled: false,
        users: [
            {
                placeholder: "Имя и фамилия родителя",
                value: "",
                error: ""
            },
            {
                placeholder: "Номер телефона",
                value: "",
                error: ""
            },
            {
                placeholder: "Электронная почта",
                value: "",
                error: ""
            },
            {
                placeholder: "Место регистрации",
                value: "",
                error: ""
            }
        ],
        selects: [
            {
                value: "Выберите класс",
                list: [
                    "1 класс",
                    "2 класс",
                    "3 класс",
                    "4 класс",
                    "5 класс",
                    "6 класс",
                    "7 класс",
                    "8 класс",
                    "9 класс",
                    "10 класс",
                    "11 класс"
                ],
                error: ""
            },
            {
                value: "Выберите пакет обучения",
                list: ["Базовый", "Классический", "Премиум"],
                error: ""
            }
            // {
            //     value: "Выберите дополнительную программу обучения",
            //     list: [
            //         "Математическая",
            //         "Гумманитарная",
            //         "Лингвистическая",
            //         "Оставить стандартную программу"
            //     ],
            //     error: ""
            // },
            // {
            //     value: "Выберите пакет консультаций",
            //     list: [
            //         "8 консультаций в месяц",
            //         "10 консульций в месяц10 консульций в месяц",
            //         "14 консультай в месяц",
            //         "Оставить стандартный пакет консультаций"
            //     ],
            //     error: ""
            // }
        ]
    }),
    methods: {
        toggleDelete() {
            this.deletepackage = !this.deletepackage;
        },
        result(item) {
            //console.log("result=>", item);
        },
        prev() {
            this.activeStep--;
        },
        next() {
            this.activeStep++;
        },
        register() {
            // let isError = false;

            // this.users.forEach((user, index) => {
            //     if (user.value == "") {
            //         this.users[index].error = "Пожалуйста, заполните поле";
            //     }
            // });

            //if (!isError) {
            axios
                .post("/sign-up", {
                    fio: this.users[0].value,
                    phone: this.users[1].value,
                    email: this.users[2].value,
                    place: this.users[3].value,
                    grade: this.selects[0].value,
                    program: this.selects[1].value
                    //additional: this.selects[2].value,
                    //consult: this.selects[3].value
                })
                .then(res => {
                    $("#modal").modal("show");
                    this.users[0].value = "";
                    this.users[1].value = "";
                    this.users[2].value = "";
                    this.users[3].value = "";
                    this.selects[0].value = "Выберите класс";
                    this.selects[1].value = "Выберите программу обучения";
                    // this.selects[2].value =
                    //     "Выберите дополнительную программу обучения";
                    // this.selects[3].value = "Выберите пакет консультаций";
                })
                .catch(err => {
                    console.log(err);
                });
            //}
        }
    }
};
</script>
