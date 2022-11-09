<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Example Component</div>
          <p v-if="mydata">
            {{ mydata }}
          </p>
          <p v-else>Ничего нет</p>
          <div class="card-body">I'm an example component.</div>
        </div>
        forma tyt
        <form v-on:submit.prevent="send">
          <div class="form-group">
            <label>Email</label>
            <div class="message">{{ validation.firstError("user.email") }}</div>
            <input type="text" class="form-control" v-model="user.email" />
          </div>
            <div class="form-group" :class="{error: validation.hasError('user.phone')}">
                <div class="label">Phone</div>
                <div class="content"><input type="text" class="form-control" v-model="user.phone" /></div>
                <div class="message">{{ validation.firstError('user.phone') }}</div>
            </div>

          <div class="form-group">
            <label>FirstName</label>
            <input type="text" class="form-control" v-model="user.fname" />
          </div>
          <div class="form-group">
            <label>LastName</label>
            <input type="text" class="form-control" v-model="user.lname" />
          </div>
          <hr />
          <button type="submit">Send</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import SimpleVueValidation from "simple-vue-validator";
const Validator = SimpleVueValidation.Validator;

export default {
  props: ["mydata"],
  data() {
    return {
      user: {
        email: null,
        fname: null,
        lname: null,
        phone: null,
      },
    };
  },
  methods: {
    send() {
      axios
        .post("/", {
          email: this.user.email,
          fname: this.user.fname,
          lname: this.user.lname,
          phone: this.user.phone,
        })
        .then((resp) => {
          console.log(resp);
        });
    },
  },
  validators: {
    "user.email": function (value) {
      console.log("test");
      return Validator.value(value).required().email();
      
    },
    "user.phone": function (value) {
      console.log("test");
     return Validator.value(value).digit().length(10);
      
    },
    "user.fname, user.lname": function (value) {
      console.log("test");
      return Validator.value(value).required().regex('^[A-Za-z]*$', 'Must only contain alphabetic characters.');
    },
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>
