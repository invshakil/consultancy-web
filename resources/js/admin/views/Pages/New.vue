<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <PageForm title="New Page"
                          short-description=""
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import PageForm from "@/components/forms/PageForm";

export default {
    components: {
        PageForm,
    },
}
</script>
