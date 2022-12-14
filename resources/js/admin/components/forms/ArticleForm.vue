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

                        <v-col cols="12" md="6">
                            <VTextFieldWithValidation v-model="form.title" rules="required" ref="title"
                                                      field="title"
                                                      :label="'Title*'"/>
                        </v-col>

                        <v-col cols="12" md="6">
                            <VSelectSearchWithValidation v-model="form.categories"
                                                         :options="categories"
                                                         rules="required"
                                                         ref="category"
                                                         field="category"
                                                         :label="`Category`"
                                                         item-text="name"/>
                        </v-col>

                        <v-col cols="12" md="4">
                            <VRadioInputWithValidation field="published"
                                                       :rules="'required'"
                                                       :options="[{label: !articleKey?'Yes':$t('Common.yes'), value: 1}, {label: !articleKey?'No':$t('Common.no'), value: 0}]"
                                                       v-model="form.published"/>
                        </v-col>
                        <v-col cols="12" md="4">
                            <VRadioInputWithValidation field="featured"
                                                       :rules="'required'"
                                                       :options="[{label: !articleKey?'Yes':$t('Common.yes'), value: 1}, {label: !articleKey?'No':$t('Common.no'), value: 0}]"
                                                       v-model="form.featured"/>
                        </v-col>

                        <v-col cols="12" md="12">
                            <span>Article (The way it is to be shown in website)</span>
                            <vue-editor :editorOptions="editorConfig"
                                        v-model="form.description"/>
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

                        <v-col cols="12" sm="12" md="6">
                            <VTextAreaFieldWithValidation v-model="form.keywords"
                                                          rules="required"
                                                          rows="2"
                                                          ref="keywords"
                                                          field="keywords"
                                                          :label="'Key words of the Article*'"
                                                          placeholder="seo keyword"
                                                          hint="Each word should be comma (,) seperated"/>

                        </v-col>

                        <v-col cols="12" md="12">
                            <VFileInputWithValidation v-model="form.image"
                                                      :image-url="form.image_url"
                                                      :rules="!articleKey ? `required` : ''"
                                                      ref="image"
                                                      field="image"
                                                      :isRow="true"
                                                      :label="form.is_video ? 'Poster*' : 'photo*'"/>
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
import articleApi from "@/api/resources/article";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";
import categoryApi from "@/api/resources/category";
import {Quill, VueEditor} from "vue2-editor";
import {ImageDrop} from 'quill-image-drop-module'
import ImageResize from 'quill-image-resize-module'

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
            default: "Article Form"
        },
        shortDescription: {
            type: String,
            default: ""
        },
        articleKey: {
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
            categories: [],
            form: {
                title: '',
                excerpt: '',
                categories:'',
                published: 0,
                featured: 0,
                description: '',
                keywords: '',
                image: '',
            }
        }
    },
    async mounted() {
        await this.getCategories();
        if (this.articleKey) {
            await this.get();
        }
    },
    methods: {
        async getCategories() {
            this.loading = true;
            await categoryApi.getCategories('*').then(res => {
                this.categories = res.data.data;
                console.log('cat', res.data.data)
                this.loading = false;
            });
        },
        async get() {
            this.loading = true;
            articleApi.get(this.articleKey).then(res => {
                res.data.data.image = null;
                if (res.data.data.categories.length) {
                    res.data.data.categories = res.data.data.categories[0].id; // for now multi category selection is not possible
                }
                if (res.data.data.keywords.length) {
                    res.data.data.keywords = res.data.data.keywords.map(item => item.title).toString();
                }
                this.form = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
        },
        save() {
            this.loading = true;
            let reqUrl;

            if (this.articleKey) {
                reqUrl = articleApi.update(this.form)
            } else {
                reqUrl = articleApi.save(this.form)
            }

            reqUrl.then(res => {
                this.$toastr.s('Data saved successful');
                this.$router.push({name: 'articles'});
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
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
