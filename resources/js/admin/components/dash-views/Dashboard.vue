<template>
    <v-container
        fill-height
        fluid
        grid-list-xl
    >
        <v-layout wrap>
            <v-flex
                sm6
                xs12
                md6
                lg6
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-multiple-check "
                    :title="`Total Applications`"
                    :value=applicationCount
                    sub-icon="mdi-update"
                    :sub-text="applicationCountLastWeek+' Applications in last week'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg6
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-multiple-check "
                    :title="`Total Jobs`"
                    :value=jobCount
                    sub-icon="mdi-update"
                    :sub-text="jobCountLastWeek+' Jobs added in last week'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-book-multiple"
                    :title="`Total Articles`"
                    :value=allArticleCount
                    sub-icon="mdi-calendar"
                    :sub-text="articleCountInLastDay+' Articles Added In Last 24 Hours'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-group"
                    :title="`  Total Visits`"
                    :value=totalVisitsAllTime
                    sub-icon="mdi-account-check"
                    sub-icon-color="success"
                    :sub-text="totalVisitsInLastDay+'  Visits in last 24 hours'"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-tag-multiple"
                    :title="`Total Subscribers`"
                    :value=getSubsCount
                    sub-icon="mdi-video"
                    :sub-text="getLastWeekSubsCount+ ` Subscribers Last Week`"
                />
            </v-flex>
            <v-flex
                sm6
                xs12
                md6
                lg3
            >
                <material-stats-card
                    :color="$store.state.app.color"
                    icon="mdi-account-multiple-check "
                    :title="`Unique User Visited`"
                    :value=visitors
                    sub-icon="mdi-update"
                    :sub-text="visitorsInLastWeek+' Unique users in last week'"
                />
            </v-flex>
            <v-flex
                md12
                lg12
            >
                <SimpleTable :color="$store.state.app.color"
                             :title="`Most Popular Articles`"
                             :sub-title="`Last Updated at ${new Date().toDateString()}`"/>
            </v-flex>

        </v-layout>
    </v-container>
</template>

<script>
// Plugins
import '@/plugins/chartist'
import MaterialCard from '@/components/material/Card'
import MaterialChartCard from '@/components/material/ChartCard'
import MaterialStatsCard from '@/components/material/StatsCard'
import SimpleTable from '@/components/general/SimpleTable'
import Api from "@/api/resources/article";

export default {
    name: 'Dashboard',
    components: {
        MaterialCard, MaterialChartCard, MaterialStatsCard, SimpleTable
    },
    data() {
        return {
            tabs: 0,
            articleCountInLastDay: 0,
            allArticleCount: 0,
            visitors: 0,
            visitorsInLastWeek: 0,
            totalVisitsInLastDay: 0,
            totalVisitsAllTime: 0,
            getSubsCount: 0,
            getLastWeekSubsCount: 0,
            dailyData: [],
            jobCount:0,
            jobCountLastWeek:0,
            applicationCount:0,
            applicationCountLastWeek:0
        }
    },

    methods: {
        complete(index) {
            this.list[index] = !this.list[index]
        },
        getCount() {
            this.loading = true;
            Api.ArticleCount().then(res => {
                this.articleCountInLastDay = res.data.countInLastDay.original.data;
                this.allArticleCount = res.data.allArticleCount.original.data;
                this.visitors = res.data.allTimeUniqueVisitors.original.data;
                this.visitorsInLastWeek = res.data.LastWeeksUniqueVisitors.original.data;
                this.totalVisitsAllTime = res.data.totalVisits.original.data;
                this.totalVisitsInLastDay = res.data.totalVisitsLastDay.original.data;
                this.getSubsCount = res.data.getSubsCount.original.data;
                this.getLastWeekSubsCount = res.data.getLastWeekSubsCount.original.data;
                this.dailyData = res.data.hitsPerDayLastWeek.original.data;
                this.jobCount = res.data.jobCount.original.data;
                this.jobCountLastWeek = res.data.jobCountLastWeek.original.data;
                this.applicationCount = res.data.applicationCount.original.data;
                this.applicationCountLastWeek = res.data.applicationCountLastWeek.original.data;
                this.loading = false;
            }).catch(err => {
                this.loading = false;
            })
        },
    },

    async created() {
        await this.getCount();
    }
}
</script>
