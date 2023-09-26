<template>
    <v-container fill-height fluid grid-list-xl>
        <v-layout justify-center wrap>
            <v-flex md12>
                <BannerForm :title="'New Banner'"
                             :short-description="$t('Common.newNewsDesc')"
                />
            </v-flex>
        </v-layout>
    </v-container>

</template>
<script>
import BannerForm from "@/components/forms/BannerForm";

export default {
    components: {
        BannerForm
    },
}
</script>
