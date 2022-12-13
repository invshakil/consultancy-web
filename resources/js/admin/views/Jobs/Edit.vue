<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <JobForm :title="$t('Common.editArticle')"
                             :job-key="$route.params.slug"/>
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import jobApi from "@/api/resources/job";
import JobForm from "@/components/forms/jobForm";

export default {
    components: {
        JobForm
    },
    data() {
        return {
            loading: false,
            slug: ''
        }
    },
    methods: {
        get() {
            this.loading = true;
            jobApi.get(this.$route.params.slug).then(res => {
                res.data.data.read_time = parseInt(res.data.data.read_time)
                res.data.data.image = null;
                this.article = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        update() {
            this.loading = true;

            this.form._method = 'PUT';
            jobApi.update(this.form).then(res => {
                this.$toastr.s('Data update successful');
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        }
    },
    created() {
        this.get();
    }
}
</script>
<style>
.ck-editor__editable {
    min-height: 300px !important;
}
</style>
