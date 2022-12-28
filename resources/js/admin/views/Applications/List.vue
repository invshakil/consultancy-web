<template>
    <v-container fill-height
                 fluid
                 grid-list-xl>
        <v-layout wrap>
            <v-flex>
                <material-card
                    :color="$store.state.app.color"
                    :title="'Applications List'"
                    :text="'Use whatsapp or email to contact, download cv, or search by filter... '"
                >
                    <v-container>
                        <v-row>
                            <v-col v-if="applicationLastDay.length>0" cols="12" md="3" class="">
                                <v-btn :color="$store.state.app.color"
                                       class="float-left">
                                    <vue-excel-xlsx
                                        :data="applicationLastDay.data"
                                        :columns="columns"
                                        :file-name="'Applications-' + formatDate(new Date())"
                                        :file-type="'xlsx'"
                                        :sheet-name="'applicant'"
                                    >
                                        Export Excel (Last Day)
                                    </vue-excel-xlsx>
                                </v-btn>
                            </v-col>
<!--                            <v-col v-else>-->
<!--                                <v-btn :color="$store.state.app.color"-->
<!--                                       class="float-left">-->
<!--                                    No Applications In Last Day-->
<!--                                </v-btn>-->
<!--                            </v-col>-->
                            <v-col cols="12" md="4" class="px-2">
                                <VSelectSearchWithValidation v-model="filter.is_published"
                                                             :options="statuses"
                                                             @change="getData"
                                                             :ref="$t('Common.createNew')"
                                                             :field="$t('Common.createNew')"
                                                             :label="$t('Common.status')"
                                                             :item-text="'name'"/>
                            </v-col>
                            <v-col cols="12" md="5" class=" pl-0">
                                <VTextFieldWithValidation v-model="filter.search"
                                                          @keyup="getData"
                                                          ref="search"
                                                          field="search"
                                                          :label="locale==='en'?'Search...':'খুজুন...'"/>
                            </v-col>
                        </v-row>

                        <v-simple-table>
                            <template v-slot:default v-if="application">
                                <thead>
                                <tr>
                                    <th class="text-left">Job</th>
                                    <th class="text-left">Applicant</th>
                                    <th class="text-left">Email</th>
                                    <th class="text-left">Phone</th>
                                    <th class="text-left">Whatsapp</th>
                                    <th class="text-left">CV</th>
                                    <th class="text-left">Toggle Contact Status</th>
                                </tr>
                                </thead>
                                <tbody v-if="loading" style="height: 100vh;">
                                <v-card-text>
                                    <v-progress-circular
                                        indeterminate
                                        color="green"
                                        class="mb-0"/>
                                </v-card-text>
                                </tbody>
                                <tbody>
                                <tr v-for="(app, index) in application.data" :key="index">
                                    <!--                                    :style="[app.is_published ? {'background': '#c8f1e0'} : {'background': '#f8d7d7'}]"-->
                                    <td>
                                        {{ app.job.title }}
                                    </td>
                                    <td style="display: flex; align-items: center; height: fit-content; padding: 45px">
                                        {{ app.name }}
                                    </td>
                                    <td>
                                        <a :href="`mailto:${app.email}`" title="Send me an email">{{ app.email }}</a>
                                    </td>
                                    <td>{{ app.phone }}</td>
                                    <td>
                                        <a :href="`https://api.whatsapp.com/send?phone=${app.whatsapp}`">{{
                                                app.whatsapp
                                            }}</a>
                                    </td>
                                    <td>
                                        <a id="id2239" target="_blank" :href="`/${app.cv}`" class="act01">Download
                                            CV</a>
                                    </td>
                                    <td>
                                        <v-icon :color="app.is_published===1?'#19b275':'#c43535'" large
                                                @click="destroy(app.id)">
                                            {{ app.is_published === 1 ? 'mdi-toggle-switch' : 'mdi-toggle-switch-off' }}
                                        </v-icon>
                                    </td>
                                </tr>
                                </tbody>
                            </template>
                        </v-simple-table>
                        <v-row justify="center">
                            <v-col cols="8">
                                <v-container class="max-width">
                                    <v-pagination
                                        v-model="application.current_page"
                                        :length="application.last_page"
                                        class="my-4"
                                        :total-visible="7"
                                        circle
                                        @input="paginate(application.current_page)"
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
import ApplicationApi from "@/api/resources/application";
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
            columns: [
                {
                    label: "Job",
                    field: "job.title",
                },
                {
                    label: "Applicant",
                    field: "name",
                },
                {
                    label: "Email",
                    field: "email",
                },
                {
                    label: "Phone",
                    field: "phone",
                },
                {
                    label: "Whatsapp",
                    field: "whatsapp",
                },
                {
                    label: "Experience (in)",
                    field: "exp_in",
                },
                {
                    label: "Experience (Abroad)",
                    field: "exp_out",
                },
                {
                    label: "Passport No.",
                    field: "passport",
                },
            ],
            publicPath: process.env.APP_URL,
            locale: this.$i18n.locale,
            loading: false,
            application: {},
            applicationLastDay: {},
            editId: null,
            categories: [
                {name: 'All', id: null},
            ],
            statuses: [
                {name: 'All', id: null},
                {name: 'Published', id: 1},
                {name: 'Pending', id: 0},
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
        padTo2Digits(num) {
            return num.toString().padStart(2, '0');
        },
        formatDate(date) {
            return (
                [
                    date.getFullYear(),
                    this.padTo2Digits(date.getMonth() + 1),
                    this.padTo2Digits(date.getDate()),
                ].join('-') +
                '_' +
                [
                    this.padTo2Digits(date.getHours()),
                    this.padTo2Digits(date.getMinutes()),
                ].join('-')
            );
        },
        getData() {
            this.loading = true;
            const query = qs.stringify(this.filter, {encode: false, skipNulls: true});

            ApplicationApi.list(this.currentPage, query).then(res => {
                this.application = res.data.data;
                this.currentPage = res.data.current_page;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        paginate(current_page) {
            this.currentPage = current_page;
            this.getData()
        },
        getLastDayData() {
            this.loading = true;
            ApplicationApi.lastDay().then(res => {
                this.applicationLastDay = res.data;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        edit(slug) {
            // this.$router.push({path: `articles/${slug}/edit`, params: {slug: slug}});
            window.location.replace(`articles/${slug}/edit`)
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                ApplicationApi.update(id).then(res => {
                    this.loading = false;
                    this.getData();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    async created() {
        await this.getLastDayData();
        await this.getData();
    },
}
</script>
