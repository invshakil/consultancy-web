<template>

    <material-card
        :color="$store.state.app.color"
        :title="title"
        :text="shortDescription"
    >
        <ValidationObserver ref="obs" v-slot="{ invalid, validated, handleSubmit, validate }">

            <v-form>
                <v-container>
                    <v-row>

                        <v-col cols="12" md="8">
                            <VTextFieldWithValidation v-model="form.title" rules="required" ref="title"
                                                      field="title"
                                                      :label="'Title*'"/>
                        </v-col>

                        <v-col cols="12" md="4">
                            <VRadioInputWithValidation field="published"
                                                       :rules="'required'"
                                                       :options="[{label: !jobKey?'Yes':$t('Common.yes'), value: 1}, {label: !jobKey?'No':$t('Common.no'), value: 0}]"
                                                       v-model="form.published"/>
                        </v-col>

                        <v-col cols="12" md="4">
                            <VSelectSearchWithValidation v-model="form.industry"
                                                         :options="industry"
                                                         rules="required"
                                                         ref="industry"
                                                         field="industry"
                                                         :label="`Industry`"
                                                         item-value="title"
                                                         item-text="title"/>
                        </v-col>

                        <v-col cols="12" md="4">
                            <VSelectSearchWithValidation v-model="form.country"
                                                         :options="countries"
                                                         rules="required"
                                                         ref="country"
                                                         field="country"
                                                         :label="`Country`"
                                                         item-text="name"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VSelectSearchWithValidation v-model="form.type"
                                                         :options="type"
                                                         rules="required"
                                                         ref="type"
                                                         field="type"
                                                         :label="`Type`"
                                                         item-text="name"/>
                        </v-col>

                        <v-col cols="12" sm="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.description"
                                                          rules="required"
                                                          rows="2"
                                                          ref="description"
                                                          field="description"
                                                          :label="'Job Description*'"
                                                          placeholder="Job Description"
                                                          hint=""/>

                        </v-col>

                        <v-col cols="12" sm="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.quality"
                                                          rules="required"
                                                          rows="2"
                                                          ref="quality"
                                                          field="quality"
                                                          :label="'Quality for candidate to have*'"
                                                          placeholder="quality required"
                                                          hint=""/>

                        </v-col>

                        <v-col cols="12" sm="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.responsibility"
                                                          rules="required"
                                                          rows="2"
                                                          ref="responsibility"
                                                          field="responsibility"
                                                          :label="'Job Responsibility*'"
                                                          placeholder="Job Responsibility"
                                                          hint=""/>

                        </v-col>

                        <v-col cols="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.excerpt"
                                                          rules="required"
                                                          ref="excerpt"
                                                          rows="2"
                                                          field="short_description"
                                                          :label="'Short Description*'"
                                                          hint="For Google SEO"/>
                        </v-col>

                        <v-col cols="12" md="4">
                            <VTextFieldWithValidation v-model="form.salary" rules="required" ref="salary"
                                                      field="salary"
                                                      :label="'Estimated Salary*'"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VSelectSearchWithValidation v-model="form.length"
                                                         :options="lengths"
                                                         rules="required"
                                                         ref="duration"
                                                         field="duration"
                                                         :label="`Contract Length`"
                                                         item-text="name"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VTextFieldWithValidation v-model="form.vacancy" rules="required" ref="vacancy"
                                                      field="vacancy"
                                                      :label="'Vacancy*'"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VTextFieldWithValidation v-model="form.exp_min" rules="required" ref="exp_min"
                                                      field="exp_min"
                                                      :label="'Min. Experience*'"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VTextFieldWithValidation v-model="form.exp_max" rules="required" ref="exp_max"
                                                      field="exp_max"
                                                      :label="'Max. Experience*'"/>
                        </v-col>

                    </v-row>
                    <v-row>
                        <v-col style="text-align: center">
                            <v-btn :loading="loading" depressed color="primary" @click="handleSubmit(save)">
                                {{ $t('Common.save') }}
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-container>
            </v-form>

        </ValidationObserver>
    </material-card>


</template>
<script>
import MaterialCard from '@/components/material/Card'
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import {ValidationObserver} from 'vee-validate'
import jobApi from "@/api/resources/job";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";
import {Quill, VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module'
import countryApi from "@/api/resources/country";
import industryApi from "@/api/resources/industry";

Quill.register('modules/imageResize', ImageResize)
Quill.register('modules/imageDrop', ImageDrop)

export default {
    components: {
        VRadioInputWithValidation,
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VSelectSearchWithValidation,
        VFileInputWithValidation,
        ValidationObserver,
        MaterialCard,
        VueEditor
    },
    props: {
        title: {
            type: String,
            default: "Job Form"
        },
        shortDescription: {
            type: String,
            default: ""
        },
        jobKey: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            locale: this.$i18n.locale,
            loading: false,
            editorConfig: {
                modules: {
                    imageDrop: true,
                    imageResize: {}
                }
            },
            countries: [],
            industry: [],
            type: [{name: 'Worker', id: 'Worker'}, {name: 'Stuff', id: 'Stuff'},],
            lengths: [
                {name: 'Unlimited', id: '0'}, {name: '1 Month', id: '1'},{name: '2 Months', id: '2'},{name: '3 Months', id: '3'},
                {name: '6 Months', id: '6'},{name: '12 Months', id: '12'},{name: '18 Months', id: '18'},{name: '24 Months', id: '24'},
                {name: '36 Months', id: '36'},
            ],
            form: {
                title: '',
                published: 0,
                quality: '',
                description: '',
                responsibility: '',
                salary: '',
                vacancy: '',
                excerpt: '',
                length: '',
                exp_min: '',
                exp_max: '',
                country: '',
                industry: '',
                type: '',
            }
        }
    },
    async mounted() {
        await this.getCountries();
        await this.getIndustries();

        if (this.jobKey) {
            await this.get();
        }
    },
    methods: {
        async getCountries() {
            this.loading = true;
            await industryApi.getIndustries('*').then(res => {
                this.industry = res.data.data;
                this.loading = false;
            });
        },
        async getIndustries() {
            this.loading = true;
            await countryApi.getCountries('*').then(res => {
                this.countries = res.data.data;
                this.loading = false;
            });
        },
        async get() {
            this.loading = true;
            jobApi.get(this.jobKey).then(res => {
                console.log('ind', res.data.data.industry)
                if (res.data.data.country.length) {
                    res.data.data.country = res.data.data.country[0].id; // for now multi country selection is not possible
                }
                if (res.data.data.industry) {
                    this.form.industry = res.data.data.industry; // for now multi industry selection is not possible
                }
                this.form = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ');
                this.loading = false;
            })
        },
        save() {
            this.loading = true;
            let reqUrl;

            if (this.jobKey) {
                reqUrl = jobApi.update(this.form)
            } else {
                reqUrl = jobApi.save(this.form)
            }

            reqUrl.then(res => {
                this.$toastr.s('Data saved successful');
                this.$router.push({name: 'jobs'});
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong!');
                this.loading = false;
            })
        }
    },
}
</script>
<style>
.editor {
    min-height: 300px !important;
}

#editor p {
    margin: 0 0 10px 0;
}
</style>
