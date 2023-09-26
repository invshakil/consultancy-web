<template>
    <v-container>
        <v-layout justify-center wrap>
            <v-flex md12>
                <material-card
                    :color="$store.state.app.color"
                    :title="`System Settings`"
                >

                    <v-container>
                        <v-row>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.app_name"
                                                          ref="app_name"
                                                          field="app_name"
                                                          :label="'App Name'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.app_url"
                                                          ref="app_name"
                                                          field="app_name"
                                                          :label="'App Url'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.blog_title"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Blog Page Title'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.blog_description"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Blog Page Description'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.study_title"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Study Page Title'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.study_description"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Study Page Description'"/>
                            </v-col>


                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.job_title"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Job Page Title'"/>
                            </v-col>
                            <v-col cols="12" md="6">
                                <VTextFieldWithValidation v-model="form.job_description"
                                                          ref="app_version"
                                                          field="app_version"
                                                          :label="'Job Page Description'"/>
                            </v-col>

                            <v-col cols="12" md="4">
                                <VTextFieldWithValidation v-model="form.home_page_title"
                                                          ref="home_page_title"
                                                          field="home_page_title"
                                                          :label="'Home page title'"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.home_page_keywords"
                                                              rules="required"
                                                              rows="2"
                                                              ref="home_page_keywords"
                                                              field="home_page_keywords"
                                                              :label="'Home page keywords*'"
                                                              placeholder="seo keyword"
                                                              hint="comma (,) separated"/>
                            </v-col>

                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.fb"
                                                              rules="required"
                                                              rows="1"
                                                              ref="fb"
                                                              field="fb"
                                                              :label="'Facebook Link*'"
                                                              placeholder="Facebook Link"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.li"
                                                              rules="required"
                                                              rows="1"
                                                              ref="li"
                                                              field="li"
                                                              :label="'LinkedIn Link*'"
                                                              placeholder="LinkedIn Link"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.tw"
                                                              rules="required"
                                                              rows="1"
                                                              ref="tw"
                                                              field="tw"
                                                              :label="'Twitter Link*'"
                                                              placeholder="Twitter Link"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.in"
                                                              rules="required"
                                                              rows="1"
                                                              ref="in"
                                                              field="in"
                                                              :label="'Instagram Link*'"
                                                              placeholder="Instagram Link"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.ad"
                                                              rules="required"
                                                              rows="1"
                                                              ref="ad"
                                                              field="ad"
                                                              :label="'Address*'"
                                                              placeholder="Address"/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.ph"
                                                              rules="required"
                                                              rows="1"
                                                              ref="ph"
                                                              field="ph"
                                                              :label="'Phone No. *'"
                                                              placeholder="Phone No. "/>
                            </v-col>
                            <v-col cols="12" md="4">
                                <VTextAreaFieldWithValidation v-model="form.mail"
                                                              rules="required"
                                                              rows="1"
                                                              ref="mail"
                                                              field="mail"
                                                              :label="'Email *'"
                                                              placeholder="Email"/>
                            </v-col>

                            <v-col cols="12" md="12">
                                <VTextAreaFieldWithValidation v-model="form.about"
                                                              rules="required"
                                                              rows="4"
                                                              ref="about"
                                                              field="about"
                                                              :label="'About*'"
                                                              placeholder="About"/>
                            </v-col>
                            <v-col cols="12" md="12">
                                <VTextAreaFieldWithValidation v-model="form.home_page_description"
                                                              rules="required"
                                                              rows="4"
                                                              ref="home_page_description"
                                                              field="home_page_description"
                                                              :label="'Home page description*'"
                                                              placeholder="Home page description"/>
                            </v-col>
<!--                            <v-col cols="12" md="12">-->
<!--                                <VFileInputWithValidation v-model="form.home_page_image"-->
<!--                                                          :image-url="form.home_page_image_url"-->
<!--                                                          ref="image"-->
<!--                                                          field="image"-->
<!--                                                          :label="'Website Logo*'"/>-->
<!--                            </v-col>-->

                        </v-row>
                    </v-container>
                    <v-card-actions style="text-align: center">
                        <v-btn depressed color="primary" @click="updateSettings">
                            Save
                        </v-btn>
                    </v-card-actions>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import Api from "@/api/resources/settings";
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";

export default {
    components: {
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VFileInputWithValidation,
        MaterialCard
    },
    data: () => ({
        loading: false,
        form: {
            app_name: '',
            app_url: '',
            blog_title: '',
            job_title: '',
            study_title: '',
            blog_description: '',
            job_description: '',
            study_description: '',
            home_page_title: '',
            home_page_description: '',
            about: '',
            fb: '',
            li: '',
            in: '',
            tw: '',
            ad: '',
            ph: '',
            mail: '',
            home_page_keywords: '',
            home_page_image: '',
            home_page_image_url: '',
        }
    }),
    methods: {
        getSettings() {
            this.loading = true;
            Api.getSettings(this.form).then(res => {
                this.form = res.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        updateSettings() {
            this.loading = true;
            Api.updateSettings(this.form).then(res => {
                this.$toastr.s('Settings update successful');
                // location.reload();
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        }
    },
    created() {
        this.getSettings();
    }
}
</script>
