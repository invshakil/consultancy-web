<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <NewsForm :title="$t('Common.newNews')"
                             :short-description="$t('Common.newNewsDesc')"
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import NewsForm from "@/components/forms/NewsForm";

export default {
    components: {
        NewsForm
    },
}
</script>
