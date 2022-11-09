<template>
    <div class="row">
        <div class="col-lg-3 setting__menu">
            <nav class="menu">
                <a
                    :class="{ menu_active_tab: tab === 0 }"
                    style="border-top-left-radius: 4px; border-top-right-radius: 4px;"
                    @click="tab = 0"
                    >Личные данные</a
                >
                <a
                    :class="{ menu_active_tab: tab === 1 }"
                    style="border-bottom-left-radius: 4px; border-bottom-right-radius: 4px;"
                    @click="tab = 1"
                    >Данные авторизации</a
                >
            </nav>
        </div>

        <user-personal-info-tab
            :user="user"
            v-if="tab === 0"
        ></user-personal-info-tab>
        <user-authorization-data-tab
            :user="user"
            v-if="tab === 1"
        ></user-authorization-data-tab>
    </div>
</template>

<script>
import SimpleVueValidation from "simple-vue-validator";

const Validator = SimpleVueValidation.Validator;

export default {
    props: ["user"],
    data() {
        return {
            tab: 0
        };
    },
    methods: {}
};
</script>
