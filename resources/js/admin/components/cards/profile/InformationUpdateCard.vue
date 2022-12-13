<template>
    <material-card
        :color="$store.state.app.color"
        :title="$t('Common.edit_profile')"
        :text="$t('Common.complete_your_profile')"
    >
        <ValidationObserver ref="profileForm" v-slot="{ handleSubmit }">
            <v-form @submit.prevent="handleSubmit(onSubmit)">
                <v-container py-0>
                    <v-layout wrap>

                        <v-flex xs12 md6>
                            <VTextFieldWithValidation :label="$t('Fields.first_name')"
                                                      field="first_name"
                                                      rules="required|min:2"
                                                      v-model="profile.first_name"
                            />
                        </v-flex>

                        <v-flex xs12 md6>
                            <VTextFieldWithValidation :label="$t('Fields.last_name')"
                                                      field="last_name"
                                                      rules="required|min:2"
                                                      v-model="profile.last_name"
                            />
                        </v-flex>
                        <v-col cols="12" md="12">
                            <VTextFieldWithValidation :label="$t('Fields.email')"
                                                      disabled
                                                      field="email"
                                                      rules="required|email"
                                                      v-model="profile.email"
                            />
                        </v-col>
                        <v-col cols="12" md="12">
                            <VTextFieldWithValidation :label="$t('Fields.email')"
                                                      hidden
                                                      field="email"
                                                      v-model="profile.locale"
                            />
                        </v-col>
                        <v-flex xs12 md6>
                            <VRadioInputWithValidation field="gender"
                                                       :rules="'required'"
                                                       :options="[{label: $t('Fields.mr'), value: 0}, {label: $t('Fields.mrs'), value: 1}]"
                                                       v-model="profile.gender"/>
                        </v-flex>

                        <v-col cols="12" md="6">
                            <VFileInputWithValidation v-model="profile.image"
                                                      ref="image"
                                                      rules=""
                                                      field="image"
                                                      :isRow="true"
                                                      :label="'Update Profile Image*'"/>
                        </v-col>

                        <v-col cols="12" md="6">
                            <v-img :src="profile.image" alt="this image"
                                   style="width: 600px; height: 300px; object-fit: contain"
                            />
                        </v-col>

                        <v-col cols="12" md="6">
                            <h3>Update Your Bio, Tell us who you are</h3>
                            <vue-editor
                                :editorOptions="editorConfig"
                                v-model="profile.bio"/>
                        </v-col>

                        <v-col cols="12" md="6">
                            <h3>Write about what you love to write</h3>
                            <vue-editor id="editor"
                                        :editorOptions="editorConfig"
                                        v-model="profile.types"/>
                        </v-col>

                        <v-flex
                            xs12
                            text-xs-right
                        >
                            <v-btn :class="`mx-0 font-weight-bold bg-color-${$store.state.app.color}`"
                                   type="submit"
                                   v-text="$t('Common.save_profile')"/>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-form>
        </ValidationObserver>
    </material-card>
</template>

<script>
import {ValidationObserver} from 'vee-validate'
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from '@/components/inputs/VTextFieldWithValidation'
import DatePickerWithValidation from '@/components/inputs/DatePickerWithValidation'
import VRadioInputWithValidation from '@/components/inputs/VRadioInputWithValidation'
import VFileInputWithValidation from '@/components/inputs/VFileInputWithValidation'
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import {Quill, VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module'
import router from "../../../router";

Quill.register('modules/imageResize', ImageResize)
Quill.register('modules/imageDrop', ImageDrop)

export default {
    name: 'information-update-card',
    components: {
        ValidationObserver,
        MaterialCard,
        VTextFieldWithValidation,
        DatePickerWithValidation,
        VRadioInputWithValidation,
        VFileInputWithValidation,
        VTextAreaFieldWithValidation,
        VueEditor
    },
    data () {
        return {
            locale:this.$i18n.locale,
            editorConfig: {
                modules: {
                    imageDrop: true,
                    imageResize: {}
                }
            },
            profile: {
                gender: 0,
                first_name: '',
                last_name: '',
                email: '',
                bio: '',
                types: '',
                image: '',
                locale: this.$i18n.locale,
            },
        }
    },
    mounted() {
        const {user} = this.$store.state
        this.profile = {
            gender: parseInt(user.gender),
            first_name: this.locale==='en'? user.first_name_en:user.first_name_bn,
            last_name: this.locale==='en'? user.last_name_en:user.last_name_bn,
            email: user.email,
            bio: this.locale==='en'? user.bio_en:user.bio_bn,
            types: this.locale==='en'? user.types_en:user.types_bn,
            image: user.image,
        }
        console.log('user', user)
    },
    methods: {
        async onSubmit() {
            const validated = await this.$refs.profileForm.validate()
            if (!validated) return
            const {address, ...profile} = this.profile
            const formData = {...profile, ...address}
            this.$store.dispatch('saveProfile', formData)
                .then(res => {
                    this.$store.dispatch('app/setSnackbarMessage', this.$t('Messages.saved_successfully'))
                    // window.location.reload()
                })
                .catch(() => this.$store.dispatch('app/setSnackbarMessage', this.$t('Messages.something_went_wrong')))
        },
    },
    watch: {
        '$i18n.locale': async function (newVal, oldVal) {
            window.location.reload()
        }
    }
}
</script>
