<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['thread'],

        components: { Replies, SubscribeButton },

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked
            };
        },

        methods: {
            toggleLock() {
                this.locked = !this.locked;

                axios[this.locked ? 'post' : 'delete']('/locked-thread/' + this.thread.slug);
            }
        }

    }
</script>
