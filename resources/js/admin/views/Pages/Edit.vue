<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <PageForm :title="$t('Common.editPage')"
                          :page-key="$route.params.slug"/>
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import PageForm from "@/components/forms/PageForm";

export default {
    components: {
        PageForm,
    }
}
</script>
<style>
.ck-editor__editable {
    min-height: 300px !important;
}
</style>
