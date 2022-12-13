<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <JobForm title="New Job"
                             short-description=""
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import JobForm from "@/components/forms/jobForm";

export default {
    components: {
        JobForm
    },
}
</script>
