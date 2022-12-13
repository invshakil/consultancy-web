<template>
    <v-container>
        <v-layout justify-center wrap>
            <v-flex>
                <v-row>
                    <v-col v-for="(widget, index) in widgets" :key="index" cols="12" md="12" sm="12">
                        <material-card
                            :color="$store.state.app.color"
                            :title="widget.title"
                        >

                            <v-container>
                                <v-row>
                                    <v-col cols="12" md="12">
                                        <VSelectSearchWithValidation v-model="page"
                                                                     :options="widget.availableData"
                                                                     @change="selectPage($event, widget.widgetName)"
                                                                     ref="page"
                                                                     field="page"
                                                                     :no-data-text="`No Page Available for selection`"
                                                                     :label="`Select Section`"
                                                                     :item-text="'title'"/>
                                    </v-col>
                                </v-row>

                                <v-row v-if="widget.data.length">
                                    <v-col cols="12" md="12">
                                    <v-simple-table>
                                        <template v-slot:default v-if="widget.data" >
                                            <thead>
                                            <tr>
                                                <th>Reorder</th>
                                                <th class="text-left">
                                                    Section Title
                                                </th>
                                                <th>
                                                    Remove
                                                </th>
                                            </tr>
                                            </thead>
                                            <draggable
                                                :list="widget.data"
                                                tag="tbody"
                                            >
                                                <tr
                                                    v-for="(page, wIndex) in widget.selectedPages"
                                                    :key="wIndex"
                                                >
                                                    <td>
                                                        <v-icon
                                                            small
                                                            class="page__grab-icon"
                                                        >
                                                            mdi-arrow-all
                                                        </v-icon>
                                                    </td>
                                                    <td> {{ page.title }}</td>
                                                    <td>
                                                        <v-icon
                                                            small
                                                            @click="removePage(wIndex, widget.widgetName, page.id)"
                                                        >
                                                            mdi-delete
                                                        </v-icon>
                                                    </td>
                                                </tr>
                                            </draggable>
                                        </template>
                                    </v-simple-table>
                                    </v-col>
                                </v-row>

                                <v-row>
                                    <v-col class="d-flex justify-end align-content-center">
                                        <v-btn :color="$store.state.app.color"
                                               @click="priorityChange(widget.widgetName)">
                                            Save Changes
                                        </v-btn>
                                    </v-col>
                                </v-row>
                            </v-container>

                        </material-card>
                    </v-col>
                </v-row>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import VFileInputWithValidation from "@/components/inputs/VFileInputWithValidation";
import pageApi from "@/api/resources/page";
import MaterialCard from '@/components/material/Card'
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import VTextAreaFieldWithValidation from "@/components/inputs/VTextAreaFieldWithValidation";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import draggable from 'vuedraggable';

export default {
    components: {
        VSelectSearchWithValidation,
        VTextAreaFieldWithValidation,
        VTextFieldWithValidation,
        VFileInputWithValidation,
        MaterialCard,
        draggable
    },
    data() {
        return {
            locale: this.$i18n.locale,
            loading: false,
            pages: [],
            news: [],
            page: '',
            footerSelectedPageId: [],
            newsSelectedPageId: []
        }
    },
    computed: {
        availableFooterPages() {
            return this.pages.filter(page => !this.footerSelectedPageId.includes(page.id));
        },
        footerPages() {
            return this.footerSelectedPageId ? this.footerSelectedPageId.map(id => this.pages.find(p => p.id === id)) : []
        },
        availableNews() {
            return this.news.filter(n => this.newsSelectedPageId !== undefined ? !this.newsSelectedPageId.includes(n.id) : []);
        },
        NewsSections() {
            return this.newsSelectedPageId ? this.newsSelectedPageId.map(id => this.news.find(n => n.id === id)) : []
        },
        widgets() {
            return [
                {
                    title: 'Footer Links',
                    availableData: this.availableFooterPages,
                    selectedPages: this.footerPages,
                    data: this.footerSelectedPageId,
                    'widgetName': 'footer_pages'
                },
                // {
                //     title: 'News Sections',
                //     availableData: this.availableNews,
                //     selectedPages: this.NewsSections,
                //     data: this.newsSelectedPageId,
                //     'widgetName': 'news_sections'
                // }
            ];
        },
        newses() {
            return [
                // {
                //     title: 'News Sections',
                //     availableData: this.availableNews,
                //     selectedPages: this.NewsSections,
                //     data: this.newsSelectedPageId,
                //     'widgetName': 'news_sections'
                // }
            ];
        }
    },
    methods: {
        getPages() {
            this.loading = true;
            pageApi.getAllPages(this.form).then(res => {
                this.pages = res.data.data.pages;
                this.footerSelectedPageId = res.data.data.footerPageIds;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong! ' + err);
                this.loading = false;
            })
            pageApi.getAllNews(this.form).then(res => {
                this.news = res.data.data.news;
                this.newsSelectedPageId = res.data.data.newsIds;
                this.loading = false;
            }).catch(err => {
                this.$toastr.e('Something went wrong!');
                this.loading = false;
            })
        },

        selectPage(pageId, type) {
            if (type === 'footer_pages') {
                this.footerSelectedPageId.push(pageId);
            } else {
                this.newsSelectedPageId.push(pageId);
            }
        },

        removePage(index, type, id) {
            if (type === 'footer_pages') {
                this.footerSelectedPageId.splice(index);
            }
            else{
                pageApi.deleteNews(id).then(res => {
                    this.$toastr.s('Updated Successfully!');
                    this.getPages()
                }).catch(err => {
                    this.$toastr.e('Something went wrong!');
                    this.loading = false;
                })
            }
        },
        priorityChange(widget_name = 'footer_pages') {
            this.loading = true;
            if (widget_name === 'footer_pages') {
                pageApi.savePageIds({ids: this.footerSelectedPageId, widget_name}).then(res => {
                    this.loading = false;
                    this.$toastr.s('Saved successfully');
                }).catch(err => {
                    this.loading = false;
                    this.$toastr.e('Something went wrong');
                })
            } else {
                pageApi.saveStatus({ids: this.newsSelectedPageId}).then(res => {
                    this.loading = false;
                    this.$toastr.s('Saved successfully');
                }).catch(err => {
                    this.loading = false;
                    this.$toastr.e('Something went wrong');
                })
            }
        }
    },

    async created() {
        await this.getPages();
    }
}
</script>
