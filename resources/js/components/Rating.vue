<template>
        <b-form-rating v-model="rate" v-on:change="addRating" stars="5"></b-form-rating>
</template>
<script>

export default {
    props: ['book_id', 'user_id', 'user_rating'],
    data() {
        return {
            rate: this.user_rating,
        };
    },
    methods: {
        addRating(){
            axios.post('/ratings', {
                rate: this.rate,
                book_id: this.book_id,
                user_id: this.user_id,
            })
            .then(response => alert('Success'))
            .catch(error => this.errors)
        },
    },
    mounted() {

    }
}
</script>
