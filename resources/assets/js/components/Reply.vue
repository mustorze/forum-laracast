<script>
import Favorite from './Favorite.vue';

export default {
    props: ['data'],

    components: { Favorite },

    data() {
        return {
            editing: false,
            body: this.data.body,
        };
    },

    methods: {
        update() {
            axios.patch('/forum/public/replies/' + this.data.id, {
                body: this.body
            });

            this.editing = false;
            flash('Updated!');

        },

        destroy() {

            axios.delete('/forum/public/replies/' + this.data.id);
            $(this.$el).fadeOut(300, () => {
                flash('Your reply has been deleted.');
            });

        }
    }
}
</script>
