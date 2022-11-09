<template>
    <div class="row col-lg-9 col-12 setting__fix">
        <!-- <div class="col-md-6 setting__block setting__fix">
            <form>
                <p>Почта</p>
                <div class="form-group">
                    <label>Введите адрес почты</label>
                    <input
                        v-model="new_email"
                        type="email"
                        class="form-control"
                        :class="{ 'is-invalid': new_email_error }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ new_email_error }}</strong>
                    </span>
                </div>
                <div class="form-group">
                    <label>Введите текущий пароль</label>
                    <input
                        v-model="current_password"
                        type="password"
                        class="form-control"
                        :class="{ 'is-invalid': current_password_error }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ current_password_error }}</strong>
                    </span>
                </div>
                <div class="block__form-btn">
                    <button
                        class="form-btn"
                        :disabled="email_loading"
                        type="button"
                        @click="updateEmail"
                    >
                        <span
                            v-if="email_loading"
                            class="spinner-grow spinner-grow-sm"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        {{ btn_email_text }}
                    </button>
                </div>
            </form>
        </div> -->
        <div class="col-md-6 setting__block setting__fix">
            <form>
                <p>Смена пароля</p>
                <div class="form-group">
                    <label>Введите текущий пароль</label>
                    <input
                        v-model="old_password"
                        type="password"
                        class="form-control"
                        :class="{ 'is-invalid': old_password_error }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ old_password_error }}</strong>
                    </span>
                </div>
                <div class="form-group">
                    <label>Введите новый пароль</label>
                    <input
                        v-model="new_password"
                        type="password"
                        class="form-control"
                        :class="{ 'is-invalid': new_password_error }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ new_password_error }}</strong>
                    </span>
                </div>
                <div class="form-group">
                    <label>Повторите пароль</label>
                    <input
                        v-model="new_confirm_password"
                        type="password"
                        class="form-control"
                        :class="{ 'is-invalid': new_confirm_password_error }"
                    />
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ new_confirm_password_error }}</strong>
                    </span>
                </div>
                <div class="block__form-btn">
                    <button
                        v-on:click="updatePassword"
                        :disabled="password_loading"
                        class="form-btn"
                        type="button"
                    >
                        <span
                            v-if="password_loading"
                            class="spinner-grow spinner-grow-sm"
                            role="status"
                            aria-hidden="true"
                        ></span>
                        {{ btn_password_text }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
export default {
    props: ["user"],
    created() {
        this.new_email = this.user.email;
    },
    data() {
        return {
            // пароль
            old_password: "",
            new_password: "",
            new_confirm_password: "",
            old_password_error: null,
            new_password_error: null,
            new_confirm_password_error: null,
            btn_password_text: "Сохранить",
            password_loading: false,
            // почта
            new_email: "",
            current_password: "",
            new_email_error: null,
            current_password_error: null,
            btn_email_text: "Сохранить",
            email_loading: false
        };
    },
    methods: {
        // пароль
        updatePassword() {
            this.password_loading = true;
            this.btn_password_text = "Загрузка...";
            axios
                .post("/user/password/update/" + this.user.id, {
                    new_password: this.new_password,
                    new_confirm_password: this.new_confirm_password,
                    old_password: this.old_password
                })
                .then(() => {
                    this.old_password = "";
                    this.new_password = "";
                    this.new_confirm_password = "";
                    this.old_password_error = null;
                    this.new_password_error = null;
                    this.new_confirm_password_error = null;
                    this.password_loading = false;
                    this.btn_password_text = "Сохранить";
                })
                .catch(error => {
                    const errors = error.response.data.errors;

                    this.old_password_error = null;
                    this.new_password_error = null;
                    this.new_confirm_password_error = null;

                    if (errors.hasOwnProperty("new_password")) {
                        this.new_password_error = errors.new_password[0];
                    }

                    if (errors.hasOwnProperty("old_password")) {
                        this.old_password_error = errors.old_password[0];
                    }

                    if (errors.hasOwnProperty("new_confirm_password")) {
                        this.new_confirm_password_error =
                            errors.new_confirm_password[0];
                    }

                    this.password_loading = false;
                    this.btn_password_text = "Сохранить";
                });
        },
        // почта
        updateEmail() {
            this.email_loading = true;
            this.btn_email_text = "Загрузка...";
            axios
                .post("/user/email/update/" + this.user.id, {
                    email: this.new_email,
                    current_password: this.current_password
                })
                .then(() => {
                    this.new_email = "";
                    this.current_password = "";
                    this.new_email_error = null;
                    this.current_password_error = null;
                    this.email_loading = false;
                    this.btn_email_text = "Сохранить";
                })
                .catch(error => {
                    const errors = error.response.data.errors;

                    this.new_email_error = null;
                    this.current_password_error = null;

                    if (errors.hasOwnProperty("email")) {
                        this.new_email_error = errors.email[0];
                    }

                    if (errors.hasOwnProperty("current_password")) {
                        this.current_password_error =
                            errors.current_password[0];
                    }

                    this.email_loading = false;
                    this.btn_email_text = "Сохранить";
                });
        }
    }
};
</script>
