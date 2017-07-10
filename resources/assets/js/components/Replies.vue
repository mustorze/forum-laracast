<template>
    <div class="">
        <div class="" v-for="reply in items">
            <reply :data="reply"></reply>
        </div>
    </div>
</template>

<script>

    import Reply from './Reply.vue';

    export default {
        props: ['data'],

        data() {
            return {
                items: this.data
            }
        }
    }

</script>
