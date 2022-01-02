<template>
    <div>
        <form action="#" method="post" name="main">
            <input type="hidden" :value="csrf_token" name="_token"/>
            <label for="username">
                Username
                <input type="text" id="username" name="username" placeholder="please enter your username"
                       v-model="username"/>
            </label>
            <br>
            <label for="city">
                City Drop-Down
                <select name="city" id="city" @change="change">
                    <option value="apple">Apple</option>
                    <option value="banana">Banana</option>
                    <option value="cat">Cat</option>
                </select>
            </label>
            <input type="submit" id="_submit" name="_submit" value="Submit"/>
            <br>
            <p>Message: {{ username }}</p>
        </form>
    </div>
</template>

<script>
export default {
    name: "FormTestComponent.vue",
    props: {
        csrf_token: {
            type: String,
            default: '',
        }
    },
    data() {
        return {
            username: 'TEST_USER'
        }
    },
    methods: {
        change(e) {
            console.log(e.target.form);
            e.target.form.submit();
        }
    }
}
</script>

<style scoped>
p {
    font-size: 30px;
}
</style>
