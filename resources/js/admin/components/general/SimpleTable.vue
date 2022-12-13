<template xmlns="http://www.w3.org/1999/html">
    <div>
        <material-card
            :color="color"
            :title="title"
            :text="subTitle"
        >
            <v-simple-table>
                <template v-slot:default>
                    <thead>
                    <tr>
                        <th v-for="header in headers" :class="[header.class || '']" :key="header.key">
                            {{ header.key.toUpperCase() }}
                        </th>
                    </tr>
                    </thead>
                    <thead v-if="loading" style="height: 100vh;">
                    <v-card-text>
                        <v-progress-circular
                            indeterminate
                            color="green"
                            class="mb-0"/>
                    </v-card-text>
                    </thead>
                    <thead v-else>
                    <tr>
                        <td>  {{locale==='en'?articles[0].title_en:articles[0].title_bn}} </td>
                        <td> {{ articles[0].viewed }}</td>
                    </tr>
                    <tr>
                        <td> {{locale==='en'?articles[1].title_en:articles[1].title_bn}}</td>
                        <td> {{ articles[1].viewed }}</td>
                    </tr>
                    <tr>
                        <td> {{locale==='en'?articles[2].title_en:articles[2].title_bn}}</td>
                        <td> {{ articles[2].viewed }}</td>
                    </tr>
                    <tr>
                        <td> {{locale==='en'?articles[3].title_en:articles[3].title_bn}}</td>
                        <td> {{ articles[2].viewed }}</td>
                    </tr>
                    <tr>
                        <td> {{locale==='en'?articles[4].title_en:articles[4].title_bn}}</td>
                        <td> {{ articles[2].viewed }}</td>
                    </tr>
                    </thead>
                </template>
            </v-simple-table>
        </material-card>
    </div>
</template>

<script>
import MaterialCard from '@/components/material/Card'
import Api from "@/api/resources/article";
import categoryApi from "@/api/resources/category";
import qs from "qs";

export default {
    components: {
        MaterialCard
    },
    props: {
        color: {
            type: String,
            default: 'accent'
        },
        headers: {
            type: Array,
            default: () => {
                return [
                    {
                        sortable: false,
                        key: 'title'
                    },
                    {
                        sortable: false,
                        key: 'view'
                    }
                ]
            }
        },
        title: {
            type: String,
            required: true
        },
        subTitle: {
            type: String,
            required: false
        }
    },
    data() {
        return {
            locale:this.$i18n.locale,
            loading: false,
            articles: {},
        }
    },
    methods: {
        getData() {
            this.loading = true;

            Api.mostRead().then(res => {
                this.articles = res.data.data
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
    },

    async created() {
        await this.getData();
    }
}
</script>
