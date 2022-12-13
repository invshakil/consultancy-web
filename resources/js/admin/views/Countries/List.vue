<template>
    <v-container>
        <v-row>
            <v-col cols="12" sm="12">
                <v-btn color="primary" class="float-left" dark @click="openForm">
                    Create new
                </v-btn>
            </v-col>
        </v-row>

        <v-row justify="center">
            <v-dialog
                v-model="dialog"
                :persistent="true"
                max-width="600px"
                hide-overlay
                transition="dialog-top-transition"
            >
                <ValidationObserver ref="obs" v-slot="{ invalid, validated, handleSubmit, validate }">
                    <v-form>
                        <v-card>
                            <v-card-title>
                                <span class="headline">New Country</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="12" sm="12" md="12">
                                            <VTextFieldWithValidation
                                                v-model="form.name"
                                                rules="required"
                                                ref="name"
                                                field="name"
                                                :label="'Country Name*'"
                                                placeholder="Bangladesh..."/>
                                        </v-col>
                                    </v-row>

                                </v-container>
                                <small>*indicates required field</small>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn
                                    color="blue darken-1"
                                    text
                                    @click="close"
                                >
                                    Close
                                </v-btn>
                                <v-btn
                                    :loading="loading"
                                    color="blue darken-1"
                                    text
                                    @click="handleSubmit(save)"
                                >
                                    Save
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-form>
                </ValidationObserver>
            </v-dialog>
        </v-row>


        <v-simple-table>
            <template v-slot:default v-if="categories">
                <thead>
                <tr>
                    <th class="text-left">
                        Name
                    </th>
                    <th class="text-left">
                        Actions
                    </th>
                </tr>
                </thead>
                <draggable
                    :list="categories.data"
                    tag="tbody"
                >
                    <tr
                        v-for="(category, index) in categories.data"
                        :key="index"
                    >
                        <td> {{ category.name }}</td>
                        <td>
                            <v-icon
                                small
                                @click="edit(category.id)"
                            >
                                mdi-pencil
                            </v-icon>

                            <v-icon
                                v-if="category.jobs_count === 0"
                                small
                                @click="destroy(category.id)"
                            >
                                mdi-delete
                            </v-icon>
                        </td>
                    </tr>
                </draggable>
            </template>
        </v-simple-table>
    </v-container>
</template>
<script>
import draggable from 'vuedraggable';
import VTextFieldWithValidation from "@/components/inputs/VTextFieldWithValidation";
import {ValidationObserver} from 'vee-validate'
import countryApi from "@/api/resources/country";
import VRadioInputWithValidation from "@/components/inputs/VRadioInputWithValidation";

export default {
    components: {
        VRadioInputWithValidation,
        VTextFieldWithValidation,
        ValidationObserver,
        draggable,
    },
    data() {
        return {
            dialog: false,
            loading: false,
            categories: {},
            editId: null,
            form: {
                name: '',
            }
        }
    },
    methods: {
        close(){
          this.dialog=false
          this.editId=null
        },
        index(page = 1) {
            this.loading = true;
            countryApi.getCountries(page).then(res => {
                this.categories = res.data.data;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        openForm() {
            this.form = {
                name: '',
            };
            this.dialog = true
        },
        edit(id) {
            this.editId = id;
            this.loading = true;
            countryApi.getCountryDetails(id).then(res => {
                for (const key of Object.keys(this.form)) {
                    this.form[key] = res.data.data[key];
                }
                this.dialog = true;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
        save() {
            this.loading = true;
            let url;

            if (this.editId === null) {
                url = countryApi.save(this.form);
            } else {
                url = countryApi.update(this.form, this.editId);
            }

            url.then(res => {
                this.index();
                this.loading = false;
                this.dialog = false;
                this.editId = null;
            }).catch(err => {
                this.loading = false;
            })
        },
        destroy(id) {
            if (confirm('Are you sure?')) {
                this.loading = true;
                countryApi.deleteCategory(id).then(res => {
                    this.loading = false;
                    this.index();
                }).catch(err => {
                    this.loading = false;
                })
            }
        }
    },
    created() {
        this.index();
    }
}
</script>
