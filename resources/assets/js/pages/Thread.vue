<script>
    import Replies from '../components/Replies.vue';
    import SubscribeButton from '../components/SubscribeButton.vue';

    export default {
        props: ['thread'],

        components: {Replies, SubscribeButton},

        data() {
            return {
                repliesCount: this.thread.replies_count,
                locked: this.thread.locked,
                editing: false,
                form: {
                    title: this.thread.title,
                    body: this.thread.body
                }
            };
        },

        methods: {
            toggleLock() {
                this.locked = !this.locked;
                let uri = `/locked-thread/${this.thread.slug}`;
                axios[this.locked ? 'post' : 'delete'](uri);
            },

            update() {
                let uri = `/threads/${this.thread.channel.slug}/${this.thread.slug}`;
                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    flash('Your thread as been updated!');
                });
            },

            cancel() {
                this.editing = false;
                this.form = {
                    title: this.thread.title,
                    body: this.thread.body
                }
            }
        }

    }
</script>
