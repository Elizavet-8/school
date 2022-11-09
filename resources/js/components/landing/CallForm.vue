<template>
    <form
        v-on:submit.prevent="orderCall"
        class="questions__form"
        id="question_form"
    >
        <input
            v-model="name"
            type="text"
            placeholder="Имя"
            class="questions__input"
        />
        <input
            v-model="phone"
            type="text"
            placeholder="Номер телефона"
            class="questions__input"
        />
        <button type="submit" class="questions__btn btn-custom">
            ПОЗВОНИТЕ МНЕ
        </button>
        <div class="modal fade" id="modal-call">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="color: #333">
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
                        <p style="color: #333">
                            Ваша заявка принята, администратор перезвонит Вам
                            <br />в течение 24 часов.
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
export default {
    data: () => ({
        name: "",
        phone: ""
    }),
    methods: {
        orderCall() {
            axios
                .post("/order-call", {
                    name: this.name,
                    phone: this.phone
                })
                .then(res => {
                    $("#modal-call").modal("show");
                    this.name = "";
                    this.phone = "";
                })
                .catch(err => {
                    console.log(err);
                });
        }
    }
};
</script>
