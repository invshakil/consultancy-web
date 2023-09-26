<template>
    <v-container fill-height
                 fluid
                 grid-list-xl>
        <v-layout wrap>
            <v-flex>
                <material-card
                    :color="$store.state.app.color"
                    :title="'Banners List'"
                    :text="$t('Common.pageFilter')"
                >
                    <v-container>
                        <v-row>
                            <v-col cols="12" md="2" class="pr-0">
                                <v-btn :color="$store.state.app.color"
                                       class="float-left"
                                       :to="{ name: 'new-banner' }">
                                    {{ $t('Common.createNew') }}
                                </v-btn>
                            </v-col>
                            <v-col cols="12" md="4" class="px-0">
                                <VSelectSearchWithValidation v-model="filter.is_published"
                                                             :options="statuses"
                                                             @change="getData"
                                                             ref="publication_status"
                                                             field="publication_status"
                                                             :label="$t('Common.status')"
                                                             :item-text="locale==='en'?'name_en':'name_bn'"/>
                            </v-col>
                            <v-col cols="12" md="6" class=" pl-0">
                                <VTextFieldWithValidation v-model="filter.search"
                                                          @keyup="getData"
                                                          ref="search"
                                                          field="search"
                                                          :label="locale==='en'?'Search...':'খুজুন...'"/>
                            </v-col>
                        </v-row>

                        <v-simple-table>
                            <template v-slot:default v-if="pages">
                                <thead>
                                <tr>
                                    <th class="text-left">{{$t('Common.title')}}</th>
                                    <th class="text-left">{{$t('Common.description')}}</th>
                                    <th class="text-left">{{$t('Common.published')}}</th>
                                    <th class="text-left">{{$t('Common.actions')}}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr v-for="(page, index) in pages" :key="index">
                                    <td style="display: flex; align-items: center;">
                                         {{locale==='en'? page.title:page.title }}
                                    </td>
                                    <td> {{locale==='en' && page.excerpt ? page.description.substr(0, 50) + '...':page.description.substr(0, 50) + '...'}}</td>
                                    <td>
                                        <v-chip
                                            small
                                            class="ma-2"
                                            text-color="white"
                                            :color="page.published ? 'success' : 'red'"
                                        >
                                            {{ page.published ? 'Published' : 'Pending' }}
                                        </v-chip>
                                    </td>
                                    <td>
                                        <v-icon small @click="edit(page.id)">mdi-pencil</v-icon>
                                        <v-icon small @click="destroy(page.id)">mdi-delete</v-icon>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-row justify="center">
                            <v-col cols="8">
                                <v-container class="max-width">
                                    <v-pagination
                                        v-model="pages.current_page"
                                        :length="pages.last_page"
                                        class="my-4"
                                        :total-visible="7"
                                        circle
                                        @input="paginate(pages.current_page)"
                                    ></v-pagination>
                                </v-container>
                            </v-col>
                        </v-row>
                    </v-container>
                </material-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
import draggable from 'vuedraggable';
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import MaterialCard from '@/components/material/Card'
import {ValidationObserver} from 'vee-validate'
import bannerApi from "@/api/resources/banner";
import VSelectSearchWithValidation from "@/components/inputs/VSelectSearchWithValidation";
import qs from "qs";

export default {
    components: {
        VSelectSearchWithValidation,
        VTextFieldWithValidation,
        ValidationObserver,
        draggable,
        MaterialCard
    },
    data() {
        return {
            locale:this.$i18n.locale,
            loading: false,
            pages: {},
            editId: null,
            categories: [
                {name: 'All', id: null},
            ],
            statuses: [
                {name_en: 'All',name_bn: 'সব', id: null},
                {name_en: 'Published',name_bn: 'প্রকাশিত', id: 1},
                {name_en: 'Pending',name_bn: 'অপেক্ষাকৃত', id: 0},
            ],
            currentPage: 1,
            filter: {
                search: null,
                category: null,
                is_published: null
            }
        }
    },
    methods: {
        getData() {
            this.loading = true;
            const query = qs.stringify(this.filter, {encode: false, skipNulls: true});

            bannerApi.list(this.currentPage, query).then(res => {
                this.pages = res.data.data.data;
                this.currentPage = res.data.data.current_page;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        paginate(current_page) {
            this.currentPage = current_page;
            this.getData()
        },
        edit(slug) {
            this.$router.push({path: `banner/${slug}/edit`, params: {slug: slug}});
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                bannerApi.delete(id).then(res => {
                    this.loading = false;
                    this.getData();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    async created() {
        await this.getData();
    }
}
</script>
