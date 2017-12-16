<template>
    <div>
        <input type="hidden" id="x" :name="name" :value="value">
        <trix-editor ref="trix" input="x" :placeholder="placeholder"></trix-editor>
    </div>
</template>

<script>
    import Trix from 'trix';

    export default {
        props: ['name', 'value', 'placeholder', 'shouldClear'],

        mounted () {
            this.$refs.trix.addEventListener('trix-change', e => {
               this.$emit('input', e.target.innerHTML);
            });

            this.$watch('shouldClear', () => {
                this.$refs.trix.value = '';
            });
        }
    }
</script>