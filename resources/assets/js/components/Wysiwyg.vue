<template>
    <div>
        <input type="hidden" id="x" :name="name" :value="value">
        <trix-editor ref="trix" input="x"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    export default {
        props: ['name', 'value'],

        mounted () {
            this.$refs.trix.addEventListener('trix-change', e => {
               this.$emit('input', e.target.innerHTML);
            });
        }
    }
</script>